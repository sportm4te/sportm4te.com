import time
import os
restart = True

while restart:
    restart = False
    os.system('python3 event-name.py')
    os.system('python3 event-description.py')
    os.system('python3 user-bio.py')
    time.sleep(1)
    restart = True