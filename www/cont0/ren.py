import os
path = "."
files = os.listdir(path)
for file in files:
	f = file.replace(" ","")
	os.rename(file,f)
