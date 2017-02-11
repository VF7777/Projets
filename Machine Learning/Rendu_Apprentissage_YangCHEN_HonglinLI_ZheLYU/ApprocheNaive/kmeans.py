# -*- coding: utf-8 -*-
from numpy import *
import numpy as np
import math
import operator
from random import randrange
import cPickle

import time

def unpickle(file):
    fo = open(file, 'rb')
    dict = cPickle.load(fo)
    fo.close()
    return dict
affiche = unpickle("cifar-10-batches-py/data_batch_1")
test = unpickle("cifar-10-batches-py/test_batch")


def distEuclid(vecA,vecB):
	#calculer la distance euclienne
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

def getResponse(neighbors):
	classVotes = {}
	if(len(neighbors)==0):
		classVotes[randrange(0, 9)] = 1
	for x in range(len(neighbors)):
		response = neighbors[x]
		if response in classVotes:
			classVotes[response] += 1
		else:
			classVotes[response] =  1
	sortedVotes = sorted(classVotes.iteritems(), key=operator.itemgetter(1), reverse=True)
	return sortedVotes[0][0]



def kMeans(trainingSet, trainingSetLabel, k):

	m = shape(trainingSet)[0]

	clusterAssment = mat(zeros((m,2)))

	centroids = randCent(trainingSet, k)
	centroidsList = []

	labels = mat(zeros((k, 1)))

	clusterChanged = True#changer cluster

	while clusterChanged:
		clusterChanged = False
		labelTraining = []
#parcourir le batch training
		for i in range(m):
			minDist = inf; minIndex = -1
			for j in range(k):
				distJI = distEuclid(centroids[j], trainingSet[i])
				if distJI < minDist:
					minDist = distJI;
					minIndex = j
			if clusterAssment[i,0] != minIndex:
			   clusterChanged = True
			clusterAssment[i,:] = minIndex,minDist**2

		for idCentroid in range(k):
			pointsClust = trainingSet[nonzero(clusterAssment[:, 0].A == idCentroid)[0]]
			#print(pointsClust)
########################ajouter l'étiquette
			trainingSetLabel = np.array(trainingSetLabel)#trainingSetLabel is a normal python list, make trainingSetLabel a numpy.array.
			labelTraining = trainingSetLabel[nonzero(clusterAssment[:,0].A==idCentroid)[0]]#les données qui ont la même étiquette
			majorLabel = getResponse(labelTraining)#trouver la plupart
			if(pointsClust.size != 0):
			    centroids[idCentroid,:] = mean(pointsClust, axis=0) #calculer la moyenne
		        labels[idCentroid,:] = majorLabel#mettre à jour les étiquettes


	#print(labels)
	for idCentroid in range(k):#ajouter l'étiquette dans centroid
		centroidsList.append((centroids.tolist()[idCentroid],labels.tolist()[idCentroid]))

	#print(centroidsList)
	return centroidsList


def getNeighbors(trainingSet,trainingSetLabel,testSet,testSetLabel,k):
	neighbors = []
	centroids = kMeans(trainingSet, trainingSetLabel, k)
	#print(len(centroids))
	for i in range(len(testSet)):
	  distances = []
	  for j in range(k):
	    dist = distEuclid(testSet[i], centroids[j][0])#calculer la distance
	    distances.append((testSet[i], centroids[j][1], testSetLabel[i],dist))#ajouter des etiquette
	  distances.sort(key=operator.itemgetter(3))#trier
	  #print(distances[i][3])
	  neighbors.append(distances[0])
	#print(neighbors)
	return neighbors


def getAccuracy(resultList,testSet):
	correct = 0
	for x in range(len(testSet)):

		if int(resultList[x][1][0]) == resultList[x][2]:
			correct += 1

	print ('> predictedLabel=' + repr((correct / float(len(testSet))) * 100.0))



n=10000#nombre de image dans un patch
k=200#nombre de centroid

trainingSetGo = affiche['data'][0:n]
trainingSetLabelGo = affiche['labels'][0:n]
testSetGo = test['data'][0:n]
testSetLabelGo = test['labels'][0:n]


result = getNeighbors(trainingSetGo,trainingSetLabelGo,testSetGo,testSetLabelGo,k)
getAccuracy(result, testSetGo)

