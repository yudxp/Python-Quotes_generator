#using POS-5890K thermal printer https://www.banggood.com/POS-5890K-58mm-Thermal-Receipt-Printer-Support-WIndows-Linux-p-1053549.html

#import gpio
import RPi.GPIO as GPIO
import time
import os

random_word = "php script.php > /dev/usb/lp0"
#os.system(random_word)

butPin = 11 #pin number, the other push button to gnd
GPIO.setmode(GPIO.BOARD) #use pin number not gpio number
GPIO.setup(butPin, GPIO.IN, pull_up_down=GPIO.PUD_UP) # Button pin set as input w/ pull-up

print("Here we go! Press CTRL+C to exit")
try:
    while 1:
        input_state = GPIO.input(butPin) # button is released
        if input_state == False:
            os.system(random_word) #call php function
            time.sleep(2) #sleep so it will not called 2x
except KeyboardInterrupt: # If CTRL+C is pressed, exit cleanly:
    GPIO.cleanup() # cleanup all GPIO