import csv
import os
os.chdir("/home/david/Sounds")

with open('allFiveInstruments.csv', 'w', newline='') as f:
    thewriter = csv.writer(f)
    thewriter.writerow(['fname','label'])
    with open('fiveInstruments.csv', 'r') as b: 
        time_reader = csv.reader(b, delimiter = ',')
        for row in time_reader:
            if row[0].endswith('.mp3'):
                thewriter.writerow([row[0][:-4] + '.wav',row[1]])
            else:
                thewriter.writerow([row[0],row[1]])
"""
with open('fiveInstruments.csv', 'w', newline='') as f:
    thewriter = csv.writer(f)
    thewriter.writerow(['fname','label'])

    violin = os.listdir('all-samples/all-samples/violin')
    cello = os.listdir('all-samples/all-samples/cello') + os.listdir('Cello')
    saxophone = os.listdir('all-samples/all-samples/saxophone') + os.listdir('Saxophone')
    clarinet = os.listdir('all-samples/all-samples/clarinet') + os.listdir('Clarinet')
    double_bass = os.listdir('all-samples/all-samples/double bass') + os.listdir('Double_bass')


    limit = 1100
    for index, fname in enumerate(violin):
        thewriter.writerow([fname,'violin'])
        if index == limit:
            break
    
    for index, fname in enumerate(cello):
        thewriter.writerow([fname,'cello'])
        if index == limit:
            break
    
    for index, fname in enumerate(saxophone):
        thewriter.writerow([fname,'saxophone'])
        if index == limit:
            break
    
    for index, fname in enumerate(clarinet):
        thewriter.writerow([fname,'clarinet'])
        if index == limit:
            break
    
    for index, fname in enumerate(double_bass):
        thewriter.writerow([fname,'double_bass'])
        if index == limit:
            break
        """