import os
import sys
from pydub import AudioSegment
os.chdir("/home/david/Sounds/5instruments")
#sys.path.append(os.path.abspath('/home/david/anaconda3/envs/py3/lib/python3.7/site-packages/pydub/__init__.py'))


for file in os.listdir("../5instruments"):
    if file.endswith(".mp3"):  
        # files                                                                         
        src = file
        dst = file[:-4] + ".wav"
        try:
            # convert wav to mp3                                                            
            sound = AudioSegment.from_mp3(file)
            sound.export(dst, format="wav")
            os.remove(file)
            print(dst)
        except Exception as e:
            pass



"""
for file in os.listdir("../5instruments"):
    if file.endswith(".wav.wav") or file.endswith(".mp3.wav"):
        print("removed: "+file)
        os.remove(file)
        """