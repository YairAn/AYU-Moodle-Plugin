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

i_course_name = argList[1]
i_assign = argList[2]
i_email = argList[3]
i_password = argList[4]
i_git_url = argList[5]
i_userid = argList[6]

def Assign_my_code(gitHub,IDs):
    try:
        git_address = WebDriverWait(driver, 5).until(EC.presence_of_element_located((By.ID, "githubUrl")))
        git_address.send_keys(gitHub)
        if(len(IDs)==2):
            col1 = WebDriverWait(driver, 5).until(EC.presence_of_element_located((By.ID, "collab1")))
            col1.send_keys(IDs[0])
            col2 = WebDriverWait(driver, 5).until(EC.presence_of_element_located((By.ID, "collab2")))
            col2.send_keys(IDs[1])
        if(len(IDs)==1):
            col1 = WebDriverWait(driver, 5).until(EC.presence_of_element_located((By.ID, "collab1")))
            col1.send_keys(IDs[0])
        x = WebDriverWait(driver, 5).until(EC.presence_of_element_located((By.ID, "saveGrade")))
        x.send_keys(Keys.RETURN)

   #needs to change from sleep(40) to wait until submission is complete!
   #do not ignore!!!
        time.sleep(40)
        text = WebDriverWait(driver, 10).until(EC.presence_of_element_located((By.CLASS_NAME, "white_square_2"))).text
        return text

    except:
        OUT += "submission faild"
        return "0"

def findAssingment(Assingment_name,gitHub,IDs):
    a = 0
    try:
         text = "//*[contains(text(), '"+Assingment_name+"')]"
         x = WebDriverWait(driver, 5).until(EC.presence_of_element_located((By.XPATH, text)))
         x.click()
    except:
        # print("assigmnet was not found")
         return "0"

    try:
        driver.implicitly_wait(5)
        text = "//button[@class='collapsible active' ]/../div/div/button"
        btn = WebDriverWait(driver, 5).until(EC.presence_of_element_located((By.XPATH, text)))
        btn.send_keys(Keys.RETURN)
        submission_ressult = Assign_my_code(gitHub,IDs)
        return submission_ressult
    except:
        OUT += "error : cant submit the assign"
        return "0"


def register_for_course(Course_name):
    try:
        text = 'Public'
        btn = WebDriverWait(driver, 5).until(EC.presence_of_element_located((By.PARTIAL_LINK_TEXT , text)))
        btn.click()
    except:
        OUT += "login failed"
        return "0"
        # driver.close()
        #os.kill(pid, signal.SIGTERM) #or signal.SIGKILL
        #exit(1)


    text = "//*[contains(text(), '"+Course_name+"')]"
    btn = WebDriverWait(driver, 10).until(EC.presence_of_element_located((By.XPATH , text)))
    btn.click()

def emailAndPass():
    try:
        email = WebDriverWait(driver, 10).until(EC.presence_of_element_located((By.NAME , "email")))
        passw = WebDriverWait(driver, 10).until(EC.presence_of_element_located((By.NAME , "password")))
        email.send_keys(i_email)
        passw.send_keys(i_password)
        btn = WebDriverWait(driver, 10).until(EC.presence_of_element_located((By.ID , "btnLogin")))
        btn.send_keys(Keys.RETURN)
        driver.implicitly_wait(9)
        return "1"
    except:
            OUT += "Email or password invalid"
            return "0"



driver.get(weburl)
ans = emailAndPass()
        
      #  driver.close()
        #os.kill(pid, signal.SIGTERM) #or signal.SIGKILL
        #exit(1)
OUT = ""
Assingment_name = i_assign
Course_name = i_course_name
gitHub = i_git_url
IDs = [0 , 0]
IDs[0] = i_userid
# if(len(argList)==8):
#   IDs[1] = argList[7]
ans = findAssingment(Assingment_name,gitHub,IDs)
if(ans=="0"):
   register_for_course(Course_name)
   ans = findAssingment(Assingment_name,gitHub,IDs)
if(ans=="0"):
    OUT += "submition faild !"
    ans = ""

OUT += ans
print(OUT)

driver.close()
driver.quit()
#pattern = "Grade:"
#index = ans.index(pattern)+7
#print(ans[index:index+5])
