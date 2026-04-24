def calculate_saw(data):
    # =========================
    # 1. definisi bobot
    # =========================
    weights = {
        "harga": 0.20,
        "jarak": 0.25,
        "rating": 0.10,
        "fasilitas": 0.15,
        "variasi_menu": 0.10,
        "jam_operasional": 0.20
    }

    # validasi bobot
    if round(sum(weights.values()), 2) != 1.00:
        raise ValueError("total bobot harus = 1")

    # =========================
    # 2. tipe kriteria
    # =========================
    cost = ["harga", "jarak"]
    benefit = ["rating", "fasilitas", "variasi_menu", "jam_operasional"]

    # =========================
    # 3. matriks keputusan (X)
    # =========================
    matrix = []
    for d in data:
        matrix.append({
            "nama": d["nama"],
            "harga": d["harga"],
            "jarak": d["jarak"],
            "rating": d["rating"],
            "fasilitas": d["fasilitas"],
            "variasi_menu": d["variasi_menu"],
            "jam_operasional": d["jam_operasional"]
        })

    # =========================
    # 4. nilai max & min
    # =========================
    max_values = {}
    min_values = {}

    for key in weights.keys():
        values = [row[key] for row in matrix]
        max_values[key] = max(values)
        min_values[key] = min(values)

    # =========================
    # 5. normalisasi (R)
    # =========================
    normalized_matrix = []

    for row in matrix:
        normalized_row = {"nama": row["nama"]}

        for key in weights.keys():
            if key in benefit:
                if max_values[key] == 0:
                    normalized_row[key] = 0
                else:
                    normalized_row[key] = row[key] / max_values[key]
            else:  # cost
                if row[key] == 0:
                    normalized_row[key] = 0
                else:
                    normalized_row[key] = min_values[key] / row[key]

        normalized_matrix.append(normalized_row)

    # =========================
    # 6. perhitungan nilai preferensi (V)
    # =========================
    results = []

    for row in normalized_matrix:
        score = 0

        for key in weights.keys():
            score += weights[key] * row[key]

        results.append({
            "nama": row["nama"],
            "score": round(score, 4)
        })

    # =========================
    # 7. ranking
    # =========================
    results = sorted(results, key=lambda x: x["score"], reverse=True)

    return {
        "matrix": matrix,
        "normalized": normalized_matrix,
        "results": results
    }