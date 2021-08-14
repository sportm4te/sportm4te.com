import time
import os
restart = True

while restart:
    time.sleep(1)
    restart = False
    os.system('python3 event-name.py')
    os.system('python3 event-description.py')
    os.system('python3 user-bio.py')
    os.system('python3 event-name-local.py')
    os.system('python3 event-description-local.py')
    os.system('python3 user-bio-local.py')
    restart = True