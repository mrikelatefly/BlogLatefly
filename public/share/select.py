import re


f=open('style1.css','r',encoding='utf-8')
content=f.read()

#print(content)
strs=input("enter words to check\n")

'''
'\.'+strs+'(,+)+\{.+\}'
\.(.+,)+strs+\{.+\}
\.(.+,)+strs+(,.+)+\{.+\}


'''
compiler=re.compile(r'\.'+strs+'(,+)+\{.+\}')


res=compiler.findall(content)
for i in res:
   print(i,end='\n')

