from numpy import *
import numpy as np
import operator

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


#collect the patchs
def collect_patch(data):
	list_patch = []
	for i in range(len(data)):
	    patchs = divide_image(data[i])
	    for j in range(len(patchs)):
		list_patch.append(patchs[j])
	return list_patch

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
	#Algorithne des k-moyennes
	print "enter kMeans"
	m = shape(dataSet)[0]   # row
	clusterAssment = mat(zeros((m,2)))
	centroids = randCent(dataSet, k)
	clusterChanged = True
	interation = 0
	while clusterChanged:
		clusterChanged = False
		for i in range(m):
			minDist = inf; minIndex = -1
			for j in range(k):
				distJI = distEuclid(centroids[j],dataSet[i])
				if distJI < minDist:
					minDist = distJI; minIndex = j
			#Si un des elements change de centroide on repart pour un tour pour optimiser encore la distance globale
			if clusterAssment[i,0] != minIndex: clusterChanged = True
			#On ajoute l'assignation de cluster et la distance par rapport a son centre
			clusterAssment[i,:] = minIndex,minDist**2   #pow(distance,2)
		# On redefinit les centroides a partir de la moyenne du cluster
		for cent in range(k):

			ptsInClust = dataSet[nonzero(clusterAssment[:,0].A==cent)[0]]
			if(ptsInClust.size != 0):
				# print ptsInClust

				centroids[cent,:] = mean(ptsInClust, axis=0)
		#On affiche la somme des distances des k centroids par rapport aux donnes pour la comparer a l'algo genetique
		# print np.sum(clusterAssment[:,1])
		interation += 1
		print interation
        print "sortir kMeans"
	return centroids, clusterAssment

