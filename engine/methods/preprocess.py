import re
from datetime import datetime


# =========================
# data understanding
# =========================

def data_understanding(data):
    print("\n=== data understanding ===")
    print("total data:", len(data))

    nama_list = [str(d.get("Nama")).strip() for d in data]
    unique_nama = set(nama_list)

    print("unique nama:", len(unique_nama))
    print("duplikat:", len(data) - len(unique_nama))


# =========================
# helper functions
# =========================

def clean_numeric_list(values):
    cleaned = []
    for v in values:
        try:
            if v != ".":
                cleaned.append(float(v))
        except:
            continue
    return cleaned


def parse_price_range(price_str):
    if not price_str:
        return 0.0

    price_str = str(price_str).lower()

    numbers = re.findall(r'[\d.]+', price_str)
    numbers = clean_numeric_list(numbers)

    if len(numbers) == 1:
        value = float(numbers[0])
        if value < 1000:
            value = value * 1000
        return value

    if len(numbers) >= 2:
        value = (numbers[0] + numbers[1]) / 2
        if value < 1000:
            value = value * 1000
        return float(value)

    return 0.0


def parse_distance(distance_str):
    if not distance_str:
        return 0.0

    distance_str = str(distance_str).lower().strip()

    numbers = re.findall(r'[\d.]+', distance_str)
    numbers = clean_numeric_list(numbers)

    if not numbers:
        return 0.0

    value = float(numbers[0])

    if "km" in distance_str:
        return value

    if "m" in distance_str:
        return value / 1000

    return value


def parse_operational_hours(time_str):
    if not time_str:
        return 0.0

    text = str(time_str).lower().strip()

    if "24" in text:
        return 24.0

    text = text.replace(".", ":").replace("–", "-")

    parts = text.split("-")

    if len(parts) < 2:
        return 0.0

    try:
        start = datetime.strptime(parts[0].strip(), "%H:%M")
        end = datetime.strptime(parts[1].strip(), "%H:%M")

        start_hour = start.hour + start.minute / 60
        end_hour = end.hour + end.minute / 60

        if end_hour < start_hour:
            diff = (24 - start_hour) + end_hour
        else:
            diff = end_hour - start_hour

        return round(diff, 2)

    except:
        return 0.0


def parse_rating(rating):
    if not rating:
        return 0.0

    text = str(rating).strip().replace(",", ".")

    try:
        return float(text)
    except:
        numbers = re.findall(r'\d+\.\d+|\d+', text)
        if numbers:
            return float(numbers[0])
        return 0.0


def count_items(text):
    if not text:
        return 0

    text = str(text)

    items = re.split(r'\n|-|,|;|\||/', text)
    items = [i.strip() for i in items if i.strip()]

    return len(items)


# =========================
# preprocessing utama
# =========================

def preprocess_data(data):
    data_understanding(data)

    processed = []
    seen = set()

    for row in data:
        nama = str(row.get("Nama")).strip()

        if nama in seen:
            continue
        seen.add(nama)

        harga = parse_price_range(row.get("Harga Menu"))
        jarak = parse_distance(row.get("Jarak"))

        if harga <= 0 or jarak <= 0:
            continue

        new_row = {
            "nama": nama,
            "harga": float(harga),
            "jarak": float(jarak),
            "rating": float(parse_rating(row.get("Rating"))),
            "fasilitas": int(count_items(row.get("Fasilitas"))),
            "variasi_menu": int(count_items(row.get("Variasi Menu"))),
            "jam_operasional": float(parse_operational_hours(row.get("Jam Operasional")))
        }

        processed.append(new_row)

    print("\n=== setelah preprocessing ===")
    print("total data:", len(processed))

    return processed