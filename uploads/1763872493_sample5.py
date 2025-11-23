s = input()
y = input()
len_s = len(s)
len_y = len(y)
import re 
x = re.search(y,s)
count=0
for i in range(len_s):
    p=()
    if s[i:i+len_y]==y:
       p = p + (i,i+len_y-1)
       print(p)
       count=count+1
       
if(count==0):
    print("(-1,-1)")
       
       

