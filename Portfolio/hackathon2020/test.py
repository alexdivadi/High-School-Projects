import numpy as np
from skimage import transform as tf

from moviepy.editor import *
from moviepy.video.tools.drawing import color_gradient


# RESOLUTION

w = 720
h = w*9/16 # 16/9 screen
moviesize = int(w),int(h)



# THE RAW TEXT
txt = "\n".join([
"Let's",
"Share",
"Baby",
"We're",
"Let",
"It's alright (alright) alright",
"Let this groove set in your shoes",
"So stand up (alright) alright",
"Gonna tell what you can do with my love",
"Alright",
"Let you know girl",
"You're looking good, you're out of sight",
"Alright",
"Just move yourself",
"And glide like a seven-forty-seven",
"And lose you're self in the sky",
"Among the clouds in the heavens 'cause",
"Let this groove light up your fuse",
"It's alright (alright) alright, oh oh",
"Let this groove set in your shoes",
"So stand up (alright) alright"
])


# Add blanks
txt = 10*"\n" +txt + 10*"\n"


# CREATE THE TEXT IMAGE


clip_txt = TextClip(txt,color='white', align='Center',fontsize=40,
                    font='Amiri-Bold', method='label')


# SCROLL THE TEXT IMAGE BY CROPPING A MOVING AREA

txt_speed = 37
fl = lambda gf,t : gf(t)[int(txt_speed*t):int(txt_speed*t+h),:]
moving_txt= clip_txt.fl(fl, apply_to=['mask'])


# ADD A VANISHING EFFECT ON THE TEXT WITH A GRADIENT MASK

grad = color_gradient(moving_txt.size,p1=(0,2*h/3),
                p2=(0,11*h/12),col1=0.0,col2=1.0)
gradmask = ImageClip(grad,ismask=True)
fl = lambda pic : np.minimum(pic,gradmask.img)
moving_txt.mask = moving_txt.mask.fl_image(fl)


background = ColorClip(size=moviesize, color=(0,0,0))

# COMPOSE THE MOVIE

final = CompositeVideoClip([background,
         moving_txt.set_pos(('center','bottom'))], 
         size=moviesize)


# WRITE TO A FILE

final.set_duration(30).write_videofile("test.mp4", fps=25)
