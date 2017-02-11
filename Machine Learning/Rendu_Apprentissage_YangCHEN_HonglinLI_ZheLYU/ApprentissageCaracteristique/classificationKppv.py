from numpy import *
import numpy as np
import operator
import time

N = 500   #the number of the cluster
K = 50     # k nearest neighbour
training_length = 2000
test_length = 2000
start_time = time.time()

#fonction for opening a file
def unpickle(file):
    import cPickle
    fo = open(file, 'rb')
    dict = cPickle.load(fo)
    fo.close()
    return dict

#open data_batch_1 and data processing
dict = unpickle("cifar-10-batches-py/data_batch_1")
value = dict.values()    # 4  data,labels,batch-label,filenames
data = value[0:1][0]     # 10000*3072 liste de listes
labels = value[1:2]
labels = labels[0]       # liste de int
filenames = value[3:4]
filenames = filenames[0]

labels_training = labels
#print type(data)    #ndarray
#array to list for treat
data = data.tolist()   #liste des listes   10000*3072

#open test_batch and data processing, data for test
dict_test = unpickle("cifar-10-batches-py/test_batch")
value_test = dict_test.values()
data_test = value_test[0:1][0]
labels_test = value_test[1:2]
labels_test = labels_test[0]

unpickle_time = time.time()
print "unpickle time: ", unpickle_time-start_time


#fonction for dividing an image into 4 patchs
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


#collect the patchs de pathch 1
list_patch = []
for i in range(training_length):
    patchs = divide_image(data[i])
    for j in range(len(patchs)):
        list_patch.append(patchs[j])

divide_image_time = time.time()
print "divide patch1 into patchs time: ",divide_image_time-unpickle_time


data_test = data_test.tolist()
def distEuclid(vecA,vecB):

	# return sqrt(sum(power(vecA - vecB,2)))
	return np.linalg.norm(np.array(vecA)-np.array(vecB))

def randCent(dataSet,k):         #the type of dataSet: matrix
	#Generation aleatoire de K centroides
	n = shape(dataSet)[1]
	centroids = mat(zeros((k,n)))
	for j in range(n):
		minJ = min(dataSet[:,j])
		rangeJ = float(max(dataSet[:,j]) - minJ)
		centroids[:,j] = minJ + rangeJ * random.rand(k,1)
	return centroids

def kMeans(dataSet, k):
	m = shape(dataSet)[0]   # the number of the row
	clusterAssment = mat(zeros((m,2)))
	centroids = randCent(dataSet, k)
	clusterChanged = True
	while clusterChanged:
		clusterChanged = False
		for i in range(m):
			minDist = inf; minIndex = -1
			for j in range(k):
				distJI = distEuclid(centroids[j],dataSet[i])
				if distJI < minDist:
					minDist = distJI; minIndex = j
			#the loop stop when all the centroids do not change
			if clusterAssment[i,0] != minIndex: clusterChanged = True
			#cluster assignment and the distance to the center are added
			clusterAssment[i,:] = minIndex,minDist**2   #pow(distance,2)
		#update the centroids
		for cent in range(k):

			ptsInClust = dataSet[nonzero(clusterAssment[:,0].A==cent)[0]]
			if(ptsInClust.size != 0):
				# print ptsInClust

				centroids[cent,:] = mean(ptsInClust, axis=0)
	return centroids, clusterAssment
dataSet = np.matrix(list_patch)
centroids, clusterAssment = kMeans(dataSet,N)

Kmeans_time = time.time()
print "Kmeans time: ", Kmeans_time-divide_image_time

def vecteur_patch(vecteur_patch,vecteur_patchs):
    size = vecteur_patchs.shape[0]
    diffMat = tile(vecteur_patch,(size,1)) - vecteur_patchs
    sqDiffMat = diffMat**2
    sqDistances = sqDiffMat.sum(axis=1)
    distances = sqDistances**0.5
    sortedDistIndicies = distances.argsort()
    return int(sortedDistIndicies[0])

def vecteur_image(image_list):    #type de image_list: list len:3072
    patchs = divide_image(image_list)  #tuple (patch1, patch2, patch3, patch4)
    vecteur = [0]*4*N
    for l in range(len(patchs)):
        index = vecteur_patch(np.asarray(patchs[l]),np.asarray(centroids.tolist()))
        vecteur[l*N+index] = 1
    return vecteur

#calculer les vecteurs des images dans patch 1
vecteur_patch1 = []
for i in range(training_length):   #change the scale   -> len(data)
    vecteur_patch1.append(vecteur_image(data[i]))

#compute the vector of the images in the test patch
vecteur_test_patch = []
for i in range(test_length):   #change the scale  -> len(data_test)
    vecteur_test_patch.append(vecteur_image(data_test[i]))

vecteur_time = time.time()
print "compute vecteur time: ", vecteur_time-Kmeans_time

# K Nearest Neighbour
def classify0(inX, dataSet, labels, k):   # ndarray ndarray list int
    dataSetSize = dataSet.shape[0]
    diffMat = tile(inX, (dataSetSize,1)) - dataSet
    sqDiffMat = diffMat**2
    sqDistances = sqDiffMat.sum(axis=1)
    distances = sqDistances**0.5
    sortedDistIndicies = distances.argsort() #ascend sorted,
    #print labels
    #return the index of unsorted, that is to choose the least 3 item
    classCount={}
    for i in range(k):
        voteIlabel = labels[sortedDistIndicies[i]]
        classCount[voteIlabel] = classCount.get(voteIlabel,0) + 1# a dict with label as key and occurrence number as value
    sortedClassCount = sorted(classCount.iteritems(), key=operator.itemgetter(1), reverse=True)
    #descend sorted according to value,
    return sortedClassCount[0][0]

#calculate the correct rate and error rate for every class
cpt = 0
cpt0 = 0
cpt1 = 0
cpt2 = 0
cpt3 = 0
cpt4 = 0
cpt5 = 0
cpt6 = 0
cpt7 = 0
cpt8 = 0
cpt9 = 0
vecteur_patch1 = np.asarray(vecteur_patch1)
vecteur_test_patch = np.asarray(vecteur_test_patch)
for i in range(len(vecteur_test_patch)):
    if classify0(vecteur_test_patch[i],vecteur_patch1,labels_training,K)==labels_test[i]:
        cpt += 1
    else:
        if labels_test[i] == 0: cpt0 +=1
        if labels_test[i] == 1: cpt1 +=1
        if labels_test[i] == 2: cpt2 +=1
        if labels_test[i] == 3: cpt3 +=1
        if labels_test[i] == 4: cpt4 +=1
        if labels_test[i] == 5: cpt5 +=1
        if labels_test[i] == 6: cpt6 +=1
        if labels_test[i] == 7: cpt7 +=1
        if labels_test[i] == 8: cpt8 +=1
        if labels_test[i] == 9: cpt9 +=1
print "correct rate: ",cpt/float(test_length)
print "error rate of class 0: ",cpt0/float(test_length)
print "error rate of class 1: ",cpt1/float(test_length)
print "error rate of class 2: ",cpt2/float(test_length)
print "error rate of class 3: ",cpt3/float(test_length)
print "error rate of class 4: ",cpt4/float(test_length)
print "error rate of class 5: ",cpt5/float(test_length)
print "error rate of class 6: ",cpt6/float(test_length)
print "error rate of class 7: ",cpt7/float(test_length)
print "error rate of class 8: ",cpt8/float(test_length)
print "error rate of class 9: ",cpt9/float(test_length)

KNN_time = time.time()
print "KNN_time: ", KNN_time-vecteur_time

