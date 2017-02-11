import numpy as np
from numpy import *
import operator
import random
import centroids as cent
import time
 
start_learning = time.time()
#variable globale: learning rate
e = 1


#variable globale: un tableau de dix vecteurs de caracteristiques pour dix classes
w = []

# K clusters pour patchs
K = 500

#initialiser le tableau de vecteurs de carateristiques
def init_vecs():
	for i in range(10):
		v = []
		for i in range(4*K):
			v.append(0)
		w.append(v)

#fonction for opening a file
def unpickle(file):
    import cPickle
    fo = open(file, 'rb')
    dict = cPickle.load(fo)
    fo.close()
    return dict

#fontion for dividing an image into 4 patchs
def divide_image(l):
    patch1 = []
    patch2 = []
    patch3 = []
    patch4 = []
    list = []
    list.append(l[0:1024])
    list.append(l[1024:2048])
    list.append(l[2048:3072])
    #list: 3*1024 listes
    cpt = 0
    for k in range(len(list)):
        for i in range(0,16):
            for j in range(0,16):
                patch1.append(list[k][32*i+j])
        for i in range(0,16):
            for j in range(16,32):
                patch2.append(list[k][32*i+j])
        for i in range(16,32):
            for j in range(0,16):
                patch3.append(list[k][32*i+j])
        for i in range(16,32):
            for j in range(16,32):
                patch4.append(list[k][32*i+j])
    return patch1,patch2,patch3,patch4


"""
perceptron algo 
il va retourner une valeur, si elle est supérieur égale au 0,
c'est à dire l'image s'attribue à cette classe;sinon, elle n'en est pas.
"""
def classify(observation, vec_params):
    nb_cara = len(vec_params)
    result = 0
    for i in  range(nb_cara):
	  result += observation[i]*vec_params[i]
    return result

# w est un tableau de dix classes
# w[i] est un tableau de 4*K valeurs de (0 ou 1)
def learn(vec_image, label):
    for i in range(10):
	result = classify(vec_image, w[i])
        #print result, label
	"""
	si l'image est de classe de i et le resultat de classification est correct 
	ensuite, on continue de tester les autres vecteur de caracteristique
	"""
	if(result >= 0 and label == i):
	  	continue
	"""
	si l'image est pas classe de i et le resultat est incorrect, on modifie le vecteur de caracteristique w[i]
	ensuite, on continue pour tester les autres vecteur de caracteristique
	"""
	if(result >= 0 and label != i):
		for j in range(len(w[i])):
			w[i][j] = w[i][j] + e * (-1) * vec_image[j]
		continue
	"""
	si l'image est de classe de i  et le resultat est incorrect, on modifie le vecteur de caracteristique w[i]
	ensuite, on continue pour tester les autres vecteur de caracteristique
	"""
        if(result < 0 and label == i):
		for j in range(len(w[i])):
			w[i][j] = w[i][j] + e * (1)* vec_image[j]
		continue

def test(dataset, labels, vec_params,centroids):
    corrects = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
    numbers = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
    result_final = 0
    for i in range(len(dataset)):
		numbers[labels[i]] += 1
		vec_image = deal_image(dataset[i],centroids)
		results = []
		for j in range(10):
			results.append(classify(vec_image, vec_params[j]))
		result_final = results.index(max(results))
		if(result_final == labels[i]):
			corrects[labels[i]] += 1
    print "correct rate in testing:" 
    for i in range(10):
	    print corrects[i]/float(numbers[i])
    print "correct rate total in testing:", sum(corrects)/(1.0*sum(numbers))

def deal_image(image,centroids):
	vec_image = []
	vec_patch1 = []
	vec_patch2 = []
	vec_patch3 = []
	vec_patch4 = []
	score1 = []
	score2 = []
	score3 = []
	score4 = []	
	score = 0

	patches = cent.divide_image(image)
	count = 0
	for centeroid in (centroids) :
		vec_patch1.append(0)
		vec_patch2.append(0)
		vec_patch3.append(0)
		vec_patch4.append(0)
		score1.append(cent.distEuclid(centeroid, patches[0]));
		score2.append(cent.distEuclid(centeroid, patches[1]));
		score3.append(cent.distEuclid(centeroid, patches[2]));
		score4.append(cent.distEuclid(centeroid, patches[3]));
	min1 = min(score1);
	vec_patch1[score1.index(min1)] = 1;
	min2 = min(score2);
	vec_patch2[score2.index(min2)] = 1;
	min3 = min(score3);
	vec_patch3[score3.index(min3)] = 1;
	min4 = min(score4);
	vec_patch4[score4.index(min4)] = 1;
	vec_image = np.concatenate((vec_patch1,vec_patch2,vec_patch3, vec_patch4), 0)
	return vec_image

# faire entrer un ensemble d'images; 
# faire sortir un ensemble de vecteur d'images
def vec_patch(centroids, dataset, labels):
	print "enter vec_patch learning"
	# indiquer le nombre d'images qu'on veut l'utiliser pour apprendre #
	for i in range(len(dataset)):
		vec_image = deal_image(dataset[i],centroids)
		learn(vec_image, labels[i])
	

batch1 = unpickle("../data_batch_1")
batch2 = unpickle("../data_batch_2")
batch3 = unpickle("../data_batch_3")
batch4 = unpickle("../data_batch_4")
batch5 = unpickle("../data_batch_5")
test_batch = unpickle("../test_batch")

#dataset =  np.concatenate((batch1['data'],batch2['data'],batch3['data'],batch4['data'],batch5['data']),0)
#labels = np.concatenate((batch1['labels'],batch2['labels'], batch3['labels'], batch4['labels'], batch5['labels']),0)
list_patch = cent.collect_patch(batch1['data'][0:5000])
data_set = np.matrix(list_patch)
result_clusters = cent.kMeans(data_set,K)
centroids = result_clusters[0]

#le traitement des images et l'apprentissage
init_vecs()
vec_patch(centroids, batch1['data'][0:5000], batch1['labels'][0:5000])
print "learning completed"

#test
end_learning = time.time()
print "K=500, data = 5000, test=5000"
print('Time of Training: ' + repr(end_learning - start_learning) + 's')
start_testing = time.time()
test(test_batch['data'][0:5000],test_batch['labels'][0:5000], w, centroids)
end_testing = time.time()
print('Time of Training: ' + repr(end_testing - start_testing) + 's')




