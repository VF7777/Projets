from numpy import *
import operator
import time

start = time.time()

#fonction for opening a file
def unpickle(file):
    import cPickle
    fo = open(file, 'rb')
    dict = cPickle.load(fo)
    fo.close()
    return dict

#open data_batch_1 and data processing
dict = unpickle("cifar-10-batches-py/data_batch_2")
print("cifar-10-batches-py/data_batch_2")
value = dict.values()    # 4  data,labels,batch-label,filenames
data = value[0:1][0]     # 10000*3072 liste de listes
labels = value[1:2]
labels = labels[0]       # liste de int
filenames = value[3:4]
filenames = filenames[0]



#open test_batch and data processing, data for test
dict_test = unpickle("cifar-10-batches-py/test_batch")
value_test = dict_test.values()
data_test = value_test[0:1][0]
labels_test = value_test[1:2]
labels_test = labels_test[0]


#data for training
data_training = data
labels_training = labels

# K Nearest Neighbour
def classify0(inX, dataSet, labels, k):
    #pdb.set_trace()
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
k = 500
print('k= ' + repr(k))

cpt0=0
cpt1=0
cpt2=0
cpt3=0
cpt4=0
cpt5=0
cpt6=0
cpt7=0
cpt8=0
cpt9=0
for i in range(len(data_test)):
    if classify0(data_test[i],data_training,labels_training,k)==labels_test[i]:
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

print ("taux de succes"+repr((cpt/float(len(data_test)))* 100.0) )

print "error rate of class 0: ",(cpt0/float(10))
print "error rate of class 1: ",(cpt1/float(10))
print "error rate of class 2: ",(cpt2/float(10))
print "error rate of class 3: ",(cpt3/float(10))
print "error rate of class 4: ",(cpt4/float(10))
print "error rate of class 5: ",(cpt5/float(10))
print "error rate of class 6: ",(cpt6/float(10))
print "error rate of class 7: ",(cpt7/float(10))
print "error rate of class 8: ",(cpt8/float(10))
print "error rate of class 9: ",(cpt9/float(10))
end = time.time()
print('Time: ' + repr((end - start)/60) + 'mins')