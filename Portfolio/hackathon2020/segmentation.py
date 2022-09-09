#Audio Segmentation
import pychorus as p

chorus_start_sec = p.find_and_output_chorus("Recording.wav", "Recording_chorus.wav", 10)

print(chorus_start_sec)
