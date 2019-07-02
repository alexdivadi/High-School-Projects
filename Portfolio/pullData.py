import selenium
from selenium import webdriver
import pandas as pd
import os
import sys
import time
from urllib.request import Request, urlopen
#----Completed Competition df index-------#
# 0: Quals
# 1: Alliances
# 2: Semifinals
# 4: Rankings
# 5: Teams(1)
# 6: Teams(2)
# 7: Awards
# 8: Points
# 9: OPR
# 10: Competition Stats
# 11-21: Averages
#-----------------------------------------#

# Get user input for competition
print("Enter a competition: ")
event = input()

# Firefox web browser
driver = webdriver.Firefox()
time.sleep(5)
# Open the website
driver.get('http://www.thebluealliance.com/events')
# Navigate to Event page
try:
	event_link = driver.find_element_by_xpath('//*[@title="'+event+'"]')
	event_link.click()
except:
	print("Invalid competition")
	driver.quit() 
	sys.exit()

# Check if competition in progress
in_progress = len(driver.find_elements_by_xpath("//*[contains(text(), 'Event in progress')]")) != 0;
in_future = len(driver.find_elements_by_xpath("//*[contains(text(), 'Results')]")) == 0;

if (in_future):
	print("No data on competition yet")
	driver.quit()
	sys.exit()

# Workaround HTML 403 Error
req = Request(driver.current_url, headers={'User-Agent': 'Mozilla/5.0'})
webpage = urlopen(req).read()

# Use pandas to grab data
df = pd.read_html(webpage, header=0)

#Close browser
driver.quit()

# Find ranking and team table
for c, table in enumerate(df):
	if 'Rank' in table.columns:
		rank = c
	if 'Location' in table.columns:
		team = c
		break

print(df)

## Data is slightly different in ongoing competitions
if (in_progress):
	qual = 2
else:
	qual = 0
#Drop unnecessary columns
new_df = df[qual][3::3]
new_df = new_df.drop('Unnamed: 0', axis=1)
new_df = new_df.drop(['Red Alliance.1', 'Red Alliance.3', 'Red Alliance.5'], axis=1)
new_df = new_df.drop(['Blue Alliance.1', 'Blue Alliance.3', 'Blue Alliance.5'], axis=1)
#Rename columns
new_df = new_df.rename(index=str, columns={"Red Alliance": "Red Team 1", "Red Alliance.2": "Red Team 2", "Red Alliance.4": "Red Team 3"})
new_df = new_df.rename(index=str, columns={"Blue Alliance": "Blue Team 1", "Blue Alliance.2": "Blue Team 2", "Blue Alliance.4": "Blue Team 3"})
new_df = new_df.rename(index=str, columns={"Scores": "Red Score", "Scores.1": "Blue Score"})

print("Data successfully retrieved!")

#Put relevant data into .csv files
if not os.path.isfile(event+'_quals.csv'):
	new_df.to_csv((event+"_quals.csv"), index=False)
else:
	print("Quals file already exists!")
if not os.path.isfile(event+'_rankings.csv'):
	df[rank].to_csv((event+"_rankings.csv"), index=False)
else:
	print("Rankings file already exists!")
if not os.path.isfile(event+'_teams_1.csv'):
	df[team].to_csv((event+"_teams_1.csv"), index=False)
else:
	print("Teams 1 file already exists!")
if not os.path.isfile(event+'_teams_2.csv'):
	df[team+1].to_csv((event+"_teams_2.csv"), index=False)
else:
	print("Teams 2 file already exists!")
