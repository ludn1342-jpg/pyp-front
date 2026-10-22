import requests
import json

def main(nit):
    s = requests.Session()
    headers = {
  "authority": "apipypsolidarioprd.movilidadbogota.gov.co",
  "method": "POST",
  "path": "/fx-pyps-datos-persona-sdm-prd/consulta-persona",
  "scheme": "https",
  "accept": "application/json, text/plain, */*",
  "accept-encoding": "gzip, deflate, br, zstd",
  "accept-language": "es-US,es-419;q=0.9,es;q=0.8,en;q=0.7",
  "content-length": "58",
  "content-type": "application/json",
  "ocp-apim-subscription-key": "c26d1c30ccab42b2b45d4a514bbb938c",
  "origin": "https://picoyplacasolidario.movilidadbogota.gov.co",
  "priority": "u=1, i",
  "referer": "https://picoyplacasolidario.movilidadbogota.gov.co/Inicio",
  "sec-ch-ua": "\"Chromium\";v=\"146\", \"Not-A.Brand\";v=\"24\", \"Google Chrome\";v=\"146\"",
  "sec-ch-ua-mobile": "?1",
  "sec-ch-ua-platform": "\"iOS\"",
  "sec-fetch-dest": "empty",
  "sec-fetch-mode": "cors",
  "sec-fetch-site": "same-site",
  "user-agent": "Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1",
  "x-user-token": "zhadlqe8ga-mnewyx8r-l1j307eiz3"
}
    data = {"NumeroIdentificacion":f"{nit}","IdTipoDocumento":"1"}
    response = s.post("https://apipypsolidarioprd.movilidadbogota.gov.co/fx-pyps-datos-persona-sdm-prd/consulta-persona", headers=headers, json=data)
    print(response.status_code)
    with open("response.txt", 'w', encoding='utf-8') as f:
        f.write(response.text)


main("900220562")