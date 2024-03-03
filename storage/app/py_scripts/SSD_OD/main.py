import torch
import torchvision
from torchvision import transforms as T

from PIL import Image
import cv2

import sys
# from google.colab.patches import cv2_imshow

image_path = sys.argv[1]

model = torchvision.models.detection.ssd300_vgg16(pretrained = True)

model.eval()

ig = Image.open(image_path)

transform = T.ToTensor()
img = transform(ig)

with torch.no_grad():
  pred = model([img])

pred[0].keys()

bboxes, scores, labels = pred[0]["boxes"], pred[0]["scores"], pred[0]["labels"]

num = torch.argwhere(scores > 0.6).shape[0]

coco_names = ["person" , "bicycle" , "car" , "motorcycle" , "airplane" , "bus" , "train" , "truck" , "boat" , "traffic light" , "fire hydrant" , "street sign" , "stop sign" , "parking meter" , "bench" , "bird" , "cat" , "dog" , "horse" , "sheep" , "cow" , "elephant" , "bear" , "zebra" , "giraffe" , "hat" , "backpack" , "umbrella" , "shoe" , "eye glasses" , "handbag" , "tie" , "suitcase" ,
"frisbee" , "skis" , "snowboard" , "sports ball" , "kite" , "baseball bat" ,
"baseball glove" , "skateboard" , "surfboard" , "tennis racket" , "bottle" ,
"plate" , "wine glass" , "cup" , "fork" , "knife" , "spoon" , "bowl" ,
"banana" , "apple" , "sandwich" , "orange" , "broccoli" , "carrot" , "hot dog" ,
"pizza" , "donut" , "cake" , "chair" , "couch" , "potted plant" , "bed" ,
"mirror" , "dining table" , "window" , "desk" , "toilet" , "door" , "tv" ,
"laptop" , "mouse" , "remote" , "keyboard" , "cell phone" , "microwave" ,
"oven" , "toaster" , "sink" , "refrigerator" , "blender" , "book" ,
"clock" , "vase" , "scissors" , "teddy bear" , "hair drier" , "toothbrush" , "hair brush"]

#font = cv2.FONT_HERSHEY_SIMPLEX

igg = cv2.imread(image_path)
result = []
for i in range(num):
  #x1, y1, x2, y2 = bboxes[i].numpy().astype("int")
  #igg = cv2.rectangle(igg, (x1, y1), (x2, y2), (0, 255, 0), 1)
  result.append(labels.numpy()[i] - 1)
  # print("Обнаружен объект:", class_name)
  #igg = cv2.putText(igg, class_name, (x1, y1 - 10), font, 0.5, (255, 0, 0), 1, cv2.LINE_AA)
print(result)
#cv2.imshow('Image', igg)
#cv2.waitKey(0)
#cv2.destroyAllWindows()
