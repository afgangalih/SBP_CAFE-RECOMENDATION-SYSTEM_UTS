# =========================
# helper: safe formatter
# =========================

def format_rupiah(value):
    try:
        value = int(value)

        # asumsi data dalam ribuan
        if value < 1000:
            value = value * 1000

        return f"Rp {value:,}".replace(",", ".")
    except:
        return "Rp 0"


# =========================
# label functions (interpretasi)
# =========================

def label_jarak(jarak):
    if jarak <= 0.5:
        return "sangat dekat"
    elif jarak <= 1.5:
        return "cukup dekat"
    elif jarak <= 3:
        return "relatif jauh"
    else:
        return "jauh"


def label_harga(harga):
    if harga <= 20000:
        return "sangat terjangkau"
    elif harga <= 35000:
        return "terjangkau"
    elif harga <= 50000:
        return "menengah"
    else:
        return "mahal"


def label_fasilitas(fasilitas):
    if fasilitas >= 10:
        return "sangat lengkap"
    elif fasilitas >= 7:
        return "lengkap"
    elif fasilitas >= 4:
        return "cukup lengkap"
    else:
        return "terbatas"


def label_jam(jam):
    if jam >= 20:
        return "sangat panjang"
    elif jam >= 14:
        return "panjang"
    elif jam >= 8:
        return "cukup"
    else:
        return "terbatas"


def label_rating(rating):
    if rating >= 4.7:
        return "sangat tinggi"
    elif rating >= 4.3:
        return "tinggi"
    elif rating >= 4.0:
        return "cukup baik"
    else:
        return "rendah"


# =========================
# core: generate alasan per cafe
# =========================

def generate_alasan(cafe):
    alasan = []

    # jarak
    alasan.append(
        f"jarak {label_jarak(cafe['jarak'])} ({round(cafe['jarak'], 2)} km)"
    )

    # harga
    alasan.append(
        f"harga {label_harga(cafe['harga'])} ({format_rupiah(cafe['harga'])})"
    )

    # fasilitas
    alasan.append(
        f"fasilitas {label_fasilitas(cafe['fasilitas'])} ({cafe['fasilitas']} fasilitas)"
    )

    # jam operasional
    alasan.append(
        f"jam operasional {label_jam(cafe['jam_operasional'])} ({round(cafe['jam_operasional'], 1)} jam)"
    )

    # rating 
    alasan.append(
        f"rating {label_rating(cafe['rating'])} ({cafe['rating']})"
    )

    return alasan


# =========================
# generate explanation untuk hasil SAW
# =========================

def attach_explanations(saw_result, original_data):
    """
    saw_result: output dari calculate_saw()
    original_data: data hasil preprocessing (list of dict)
    """

    results = saw_result["results"]

    # mapping nama → data asli
    data_map = {d["nama"]: d for d in original_data}

    enriched_results = []

    for r in results:
        nama = r["nama"]

        cafe_data = data_map.get(nama)

        if not cafe_data:
            continue

        alasan = generate_alasan(cafe_data)

        enriched_results.append({
            "nama": nama,
            "score": r["score"],
            "alasan": alasan
        })

    return enriched_results