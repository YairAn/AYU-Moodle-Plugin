import time
import sys
import re
import selenium
import os
from os import getpid
import signal
from selenium import webdriver
from selenium.webdriver.chrome.options import Options
from selenium.webdriver.common.by import By
from selenium.webdriver.common.keys import Keys
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC, wait

argList = sys.argv
pid  = getpid()
weburl = "http://104.248.40.179/"
PATH = "C:\chromedriver.exe"
#chrome_options = Options()
#chrome_options.add_argument("--headless")
#driver = webdriver.Chrome(chrome_options=chrome_options)
driver = webdriver.Chrome(PATH)

i_course_name = argList[1].replace("~"," ")
i_assign = argList[2].replace("~"," ")
i_email = argList[3]
i_password = argList[4]
i_git_url = argList[5]


global OUT
OUT = ""

def Assign_my_code(gitHub,IDs):
    try:
        git_address = WebDriverWait(driver, 5).until(EC.presence_of_element_located((By.ID, "githubUrl")))
        git_address.send_keys(gitHub)
        x = WebDriverWait(driver, 5).until(EC.presence_of_element_located((By.ID, "saveGrade")))
        x.send_keys(Keys.RETURN)

   #needs to change from sleep(40) to wait until submission is complete!
   #do not ignore!!!
        time.sleep(40)
        text = WebDriverWait(driver, 10).until(EC.presence_of_element_located((By.CLASS_NAME, "white_square_2"))).text
        return text

    except:
        global OUT
        OUT += " submission faild"
        return "0"

def findAssingment(Assingment_name,gitHub,IDs):

    try:
         text = "//*[contains(text(), '"+Assingment_name+"')]"
         x = WebDriverWait(driver, 5).until(EC.presence_of_element_located((By.XPATH, text)))
         x.click()
    except:
         global OUT
         OUT = "assignment was not found"
         return "0"

    try:
        driver.implicitly_wait(5)
        text = "//button[@class='collapsible active' ]/../div/div/button"
        btn = WebDriverWait(driver, 5).until(EC.presence_of_element_located((By.XPATH, text)))
        btn.send_keys(Keys.RETURN)
        submission_result = Assign_my_code(gitHub,IDs)
        return submission_result
    except:
        global OUT
        OUT = OUT + "error : cant submit the assign"
        return "0"


def register_for_course(Course_name):
    try:
        text = 'Public'
        btn = WebDriverWait(driver, 5).until(EC.presence_of_element_located((By.PARTIAL_LINK_TEXT , text)))
        btn.click()
        text = "//*[contains(text(), '"+Course_name+"')]"
        btn = WebDriverWait(driver, 10).until(EC.presence_of_element_located((By.XPATH , text)))
        btn.click()
    except:
        global OUT
        OUT = OUT + "invalid assignment "
        return "0"


def emailAndPass():
    try:
        email = WebDriverWait(driver, 10).until(EC.presence_of_element_located((By.NAME , "email")))
        passw = WebDriverWait(driver, 10).until(EC.presence_of_element_located((By.NAME , "password")))
        email.send_keys(i_email)
        passw.send_keys(i_password)
        btn = WebDriverWait(driver, 10).until(EC.presence_of_element_located((By.ID , "btnLogin")))
        btn.send_keys(Keys.RETURN)
        driver.implicitly_wait(9)
        try:
                 text = "//a[contains(@href, '#mycourses')]"
                 x = WebDriverWait(driver, 5).until(EC.presence_of_element_located((By.XPATH, text)))
        except:
            global OUT
            OUT += "Email or password invalid"
            return "0"
        return "1"
    except:
        return "0"



driver.get(weburl)
ans = emailAndPass()
if(ans == "0"):
    print(OUT)
    driver.close()
    driver.quit()
else:
    Assingment_name = i_assign
    Course_name = i_course_name
    gitHub = i_git_url
    IDs = [0]
    ans = findAssingment(Assingment_name,gitHub,IDs)
    if(ans=="0"):
       register_for_course(Course_name)
       ans = findAssingment(Assingment_name,gitHub,IDs)
    if(ans=="0"):
        OUT += " submition faild !"
        ans = ""

    OUT += ans
    print(OUT)
    driver.close()
    driver.quit()

