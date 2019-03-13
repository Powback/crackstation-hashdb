import math

with open("events_v6.txt") as f:
	var = f.readlines()

count = len(var)
print(count)
input = 2551737203
print 'input is: ', input

level = math.floor(math.log(input)/math.log(count))
print 'level is: ', level +1

subtract = level
corInput = input

while subtract > 0:
	print "corInput", corInput
	print "count", count
	print "subtract", subtract
	corInput = corInput - count**subtract


	print 'calculating relative number ', corInput
	subtract -= 1
else:
	print 'relative position calculated! It is:', corInput

level = level+1
i=0
out=""

corInputNullBased = corInput


while i < level:
	print "i:",i
	print (corInput/count)**i%count
	sec = math.floor(corInput/count**i%count)

	print sec
	out = var[int(sec)].rstrip() + out
	print var[int(sec)]
	print'The ', i, 'th number is: ', sec
	i+=1

print 'The total string is: ', out

