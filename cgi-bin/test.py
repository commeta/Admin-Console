#!/usr/bin/env python3
# Import modules for CGI handling
# https://www.tutorialspoint.com/python3/python_cgi_programming.htm
# https://admin.webdevops.ru/cgi-bin/test.py?first_name=im
# https://python-scripts.com/resize-a-photo-with-python
# https://github.com/uploadcare/pillow-simd/tree/simd/master/docs
# https://pillow.readthedocs.io/en/latest/handbook/tutorial.html#using-the-image-class
# https://python-pillow.org/
# https://habr.com/ru/company/oleg-bunin/blog/425471/
# https://bookflow.ru/pillow-obrabotka-izobrazhenij-v-python-na-primerah/
# https://python-scripts.com/pymysql
# https://o7planning.org/ru/11463/connecting-mysql-database-in-python-using-pymysql
# Ресайз, конвертер, вставка логотипа, водяные знаки

# http://admin.local/cgi-bin/test.py?query=list_all_images
# apt install python3-pymysql python-pil

import cgi
import cgitb
import pymysql
import json
import os

from PIL import Image
from pathlib import Path
from pymysql.cursors import DictCursor


def list_all_images():
    count_files = 0
    files = {}
    request = {}

    directory = Path(os.getcwd()).parent
    extension = ".jpg,.jpeg,.png"
    extensions = extension.split(',')

    for image in directory.glob('**/*'):
        if image.is_file() and all(not str(image).lower().endswith(ext) for ext in extensions):
            continue

        if image.is_dir():
            continue
        
        file_image = {}
        with Image.open(str(image)) as img:
            file_image['width'], file_image['height'] = img.size
        
        file_image['path'] = str(image)

        files[count_files] = file_image
        count_files = count_files + 1

    request['directory'] = str(directory)
    request['files'] = files

    return(files)


if __name__ == '__main__':  # Required arguments
    con = pymysql.connect(
        'localhost', 'dev_admin_console', 'G4u5W8x1', 'dev_admin_console')

    xauthtoken = "45647"
    with con: # Проверка авторизации
        cur = con.cursor()
        cur.execute(
            "SELECT user_login_id, user_id FROM md_users_login WHERE xauthtoken=%s", xauthtoken)
        row = cur.fetchone()

    # Create instance of FieldStorage 
    form = cgi.FieldStorage()
    # Get data from fields
    query = form.getvalue('query')



    print("Content-type:application/json\n\n")

    data = {}
    if row == None:
        data['db_message'] = "Не авторизованный сеанс"
    else:
        data['db_message'] = row



    #if query == "list_all_images":
    data['request'] = list_all_images()



    print(json.dumps(data))

