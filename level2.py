import math
with open('abc.txt') as f:
    var = f.readlines()
count = len(var)
print(count)
input = 66371320000
print('input is: ', input)

print( math.log(input)/math.log(count))
level = math.floor(round(math.log(input*2+1)/math.log(count),6))

print('level is: ', level)

subtract = level-1
corInput = input

while subtract > 0:
    corInput = corInput - count**subtract
    print('calculating relative number ', corInput)
    subtract -= 1
else:
    print('relative position calculated! It is:', corInput)

list = level-1
i=0
out=""

corInputNullBased = corInput-1

while i < level:
    sec = math.floor(corInputNullBased/count**i%count)
    out = var[int(sec)] + out
    print('The ', i, 'th number is: ', sec)
    i+=1
else:
    print('The total string is: ',out)
    
