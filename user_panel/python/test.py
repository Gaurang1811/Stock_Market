
import csv

with open("datasets/500290.csv", "r") as f:
    data = list(csv.reader(f))
    print(data[0])
    print(len(data))
i = 15;
with open("datasets/500290.csv", "w") as f:
    writer = csv.writer(f)
    writer.writerow(data[0])
    while i < len(data):
        writer.writerow(data[i])
        i = i + 1;
