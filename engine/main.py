import pandas as pd
from methods.preprocess import preprocess_data
from methods.saw import calculate_saw
from methods.filter import filter_data
from methods.explain import attach_explanations


# =========================
# load dataset
# =========================
df = pd.read_excel("data/List Cafe.xlsx")

print("=== nama kolom dataset ===")
print(df.columns)

data = df.to_dict(orient="records")


# =========================
# preprocessing
# =========================
processed = preprocess_data(data)

print("\n=== sample preprocessing ===")
for p in processed[:5]:
    print(p)


# =========================
# FUNCTION SCENARIO TEST
# =========================
def run_scenario(name, filters):
    print(f"\n=== SCENARIO: {name} ===")

    # filter
    if filters:
        filtered = filter_data(processed, filters)
        print("jumlah data:", len(filtered))
    else:
        filtered = processed
        print("tanpa filter (semua data digunakan)")

    # handle empty
    if len(filtered) == 0:
        print("tidak ada data lolos filter ❌")
        return

    # =========================
    # SAW
    # =========================
    result = calculate_saw(filtered)

    # =========================
    # EXPLAIN (tambahan)
    # =========================
    final_result = attach_explanations(result, filtered)

    # =========================
    # OUTPUT TEST
    # =========================
    print("top 3 hasil + alasan:")

    for r in final_result[:3]:
        print("\n---------------------")
        print("nama :", r["nama"])
        print("score:", r["score"])
        print("alasan:")
        for a in r["alasan"]:
            print("-", a)


# =========================
# SCENARIO TESTING
# =========================

# 1. tanpa filter
run_scenario("tanpa filter", {})

# 2. mahasiswa (dekat & murah)
run_scenario("mahasiswa", {
    "max_jarak": 1.5,
    "max_harga": 30000,
    "min_fasilitas": 5
})

# 3. premium (mahal & lengkap)
run_scenario("premium", {
    "max_jarak": 3.0,
    "max_harga": 100000,
    "min_fasilitas": 10
})

# 4. fokus fasilitas
run_scenario("fasilitas tinggi", {
    "min_fasilitas": 10
})

# 5. super dekat
run_scenario("super dekat", {
    "max_jarak": 0.5
})

# 6. murah saja
run_scenario("murah saja", {
    "max_harga": 20000
})

# 7. filter ketat
run_scenario("filter ketat", {
    "max_jarak": 0.3,
    "max_harga": 15000,
    "min_fasilitas": 10
})