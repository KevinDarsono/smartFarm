from paho.mqtt import client as mqtt_client
from dotenv import load_dotenv
from pathlib import Path
import os, random, time

dotenv_path = Path('../.env')
load_dotenv(dotenv_path=dotenv_path)

MQTT_HOST = os.getenv('MQTT_HOST')
MQTT_PORT = 1883
MQTT_TOPIC = os.getenv('MQTT_TOPIC')+'/11011711010711911100014012'
MQTT_USERNAME = os.getenv('MQTT_USERNAME')
MQTT_PASSWORD = os.getenv('MQTT_PASSWORD')

client_id = f'python-mqtt-{random.randint(0, 1000)}'

def connect_mqtt():
    def on_connect(client, userdata, flags, rc):
        if rc == 0:
            print("Connected to MQTT Broker!" + " " + str(MQTT_HOST))
        else:
            print("Failed to connect, return code %d\n", rc)

    client = mqtt_client.Client(client_id)
    client.on_connect = on_connect
    client.username_pw_set(MQTT_USERNAME, MQTT_PASSWORD)
    client.connect(MQTT_HOST, MQTT_PORT)
    return client

def publish(client):
    while True:
        time.sleep(1)
        device_id = '11011711010711911100014012'
        temperature = round(random.uniform(27, 33), 2)
        humidity = round(random.uniform(0, 100), 2)
        soil_moisture = round(random.uniform(0, 100), 2)
        soil_ph = round(random.uniform(0, 100), 2)
        water_ph = round(random.uniform(0, 100), 2)
        light = round(random.uniform(100, 1000), 2)
        wind_speed = round(random.uniform(0, 32), 2)
        rain = round(random.uniform(0, 100), 2)
        latitude = '-6.4095639936874145'
        longitude = '108.26466406165014'
        msg = f'{device_id},{temperature},{humidity},{soil_moisture},{soil_ph},{water_ph},{light},{wind_speed},{rain},{latitude},{longitude}'

        result = client.publish(MQTT_TOPIC, msg)
        # result: [0, 1]
        status = result[0]
        if status == 0:
            print(f"Send `{msg}` to topic `{MQTT_TOPIC}`")
        else:
            print(f"Failed to send message to topic {MQTT_TOPIC}")

def main():
    client = connect_mqtt()
    client.loop_start()
    publish(client)

if __name__ == "__main__":
    main()
