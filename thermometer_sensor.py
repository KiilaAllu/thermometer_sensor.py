import os
import glob
import time
import datetime
import MySQLdb
from time import strftime

db = MySQLdb.connect(host="localhost", user="alvari", passwd="alvari", db="sensor") # replace password with your password
cur = db.cursor()

os.system('modprobe w1-gpio')
os.system('modprobe w1-therm')

base_dir = '/sys/bus/w1/devices/'
device_folder = glob.glob(base_dir + '28*')[0]
device_file = device_folder + '/w1_slave'

def dateTime():
	secs = float(time.time())
	secs = secs*1000
	return secs

def read_temp_raw():
    f = open(device_file, 'r')
    lines = f.readlines()
    f.close()
    return lines

def read_temp():
    lines = read_temp_raw()
    while lines[0].strip()[-3:] != 'YES':
        time.sleep(0.2)
        lines = read_temp_raw()
    equals_pos = lines[1].find('t=')
    if equals_pos != -1:
        temp_string = lines[1][equals_pos+2:]
        temp_c = float(temp_string) / 1000.0
        return temp_c

secs = dateTime()
temperature = read_temp()

try:
	print(read_temp())
	print "Writing to the database..."
	cur.execute(*sql)
	db.commit()
	print "Write complete"

	time.sleep(1)

except:
	db.rollback()
	print "We have a problem"

cur.close()
db.close()

print secs
print temperature
