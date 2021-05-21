import time
import selenium
from selenium import webdriver
from selenium.webdriver.chrome.options import Options
from selenium.webdriver.common.by import By
from selenium.webdriver.common.keys import Keys
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC, wait

weburl = "http://104.248.40.179/"
PATH = "C:\chromedriver.exe"
driver = webdriver.Chrome(PATH)

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
     print("submission faild")
     return 0

def findAssingment(Assingment_name,gitHub,IDs):
    a = 0
    try:
         text = "//*[contains(text(), '"+Assingment_name+"')]"
         x = WebDriverWait(driver, 5).until(EC.presence_of_element_located((By.XPATH, text)))
         x.click()
    except:
         print("assigmnet was not  found")
    
    try:
        driver.implicitly_wait(5)
        text = "//button[@class='collapsible active' ]/../div/div/button"
        btn = WebDriverWait(driver, 10).until(EC.presence_of_element_located((By.XPATH, text)))
        btn.send_keys(Keys.RETURN)
        submission_ressult = Assign_my_code(gitHub,IDs)
    except:
        print("error")


def register_for_course(Course_name):
 try:
    text = 'Public'
    btn = WebDriverWait(driver, 10).until(EC.presence_of_element_located((By.PARTIAL_LINK_TEXT , text)))
    btn.click()
    print("login sucses")
 except:
    print("login failed")
    
 text = "//*[contains(text(), '"+courseName+"')]"
 btn = WebDriverWait(driver, 10).until(EC.presence_of_element_located((By.XPATH , text)))
 btn.click()

driver.get(weburl)
email = WebDriverWait(driver, 10).until(EC.presence_of_element_located((By.NAME , "email")))
passw = WebDriverWait(driver, 10).until(EC.presence_of_element_located((By.NAME , "password")))
email.send_keys("maccavi2@gmail.com")
passw.send_keys("123456")
btn = WebDriverWait(driver, 10).until(EC.presence_of_element_located((By.ID , "btnLogin")))
btn.send_keys(Keys.RETURN)
courseName = "OOP"
driver.implicitly_wait(9)
Assingment_name = 'Solver - A'
Course_name = 'OOP'
gitHub = "https://github.com/AviBoter/solver-a"
IDs = []
ans = findAssingment(Assingment_name,gitHub,IDs)
if(ans==0):
 register_for_course(Course_name)

print(ans)
    
