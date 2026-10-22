import requests
import json

def main(nit):
    s = requests.Session()
    headers = {}
    response = s.post("", headers=headers)
    print(response.status_code)
    with open("response.txt", 'w', encoding='utf-8') as f:
        f.write(response.text)


main("900220562")