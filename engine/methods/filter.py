def filter_data(data, filters):
    filtered = []

    for d in data:

        # ===== jarak (max) =====
        if "max_jarak" in filters and filters["max_jarak"] is not None:
            if d["jarak"] > filters["max_jarak"]:
                continue

        # ===== harga (max) =====
        if "max_harga" in filters and filters["max_harga"] is not None:
            if d["harga"] > filters["max_harga"]:
                continue

        # ===== fasilitas (min) =====
        if "min_fasilitas" in filters and filters["min_fasilitas"] is not None:
            if d["fasilitas"] < filters["min_fasilitas"]:
                continue

        # ===== rating (min) =====
        if "min_rating" in filters and filters["min_rating"] is not None:
            if d["rating"] < filters["min_rating"]:
                continue

        # ===== jam operasional (min) =====
        if "min_jam" in filters and filters["min_jam"] is not None:
            if d["jam_operasional"] < filters["min_jam"]:
                continue

        filtered.append(d)

    return filtered