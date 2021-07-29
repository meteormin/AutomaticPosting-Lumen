from selenium import webdriver  # Selenium
from selenium.common.exceptions import NoSuchElementException
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from selenium.webdriver.common.by import By
from selenium.common.exceptions import TimeoutException
from bs4 import BeautifulSoup  # BeautifulSoup4
import os
import sys
import json
import requests
import configparser


def configure():
    config = configparser.ConfigParser()
    config.read('config/client_info.ini')

    return config


def make_url():
    print('request')
    config = configure()
    uri = config['tistory']['host'] + '/oauth/authorize'
    uri += '?client_id=' + config['tistory']['client_id'] + '&redirect_uri=' + config['tistory'][
        'redirect_uri'] + '&response_type=code&state=a'
    return uri


url = make_url()

current_path = os.path.dirname(os.path.abspath(__file__))
options = webdriver.ChromeOptions()

options.add_argument('headless')
print(url)
print('selenium')
if os.name in ['posix', 'Linux', 'linux']:
    print('start linux')

    try:
        print('start no driver')
        driver = webdriver.Chrome(options=options)
        print('started no driver')
    except:
        print('start driver')
        print(current_path + '/chromedriver')
        driver = webdriver.Chrome(executable_path=current_path + '/chromedriver',
                                  options=options)  # linux 크롬드라이버 실행라즈베리파이 chromium
        print('started driver')
        driver.get(url)
        print('get:', url)
elif os.name in ['nt']:
    print('start windows')
    driver = webdriver.Chrome(
        current_path + '/chromedriver.exe', options=options)  # windows 크롬드라이버 실행
else:
    print("error : not support OS")
    sys.exit()
print('start getaa')
driver.get(url)
print('get:', url)
try:
    WebDriverWait(driver, 5).until(
        EC.presence_of_element_located((By.CLASS_NAME, 'confirm'))
    )
    print("info: page is ready")
except TimeoutException:
    print("error: timeout 5s")
try:
    driver.find_element_by_class_name('confirm').click()
    print("click!")
except NoSuchElementException:
    print('no such')

print('aa')
