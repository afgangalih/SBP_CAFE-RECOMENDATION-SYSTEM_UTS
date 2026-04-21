import sys
import json

def get_input_data():
    try:
        input_string = sys.stdin.read()
        if not input_string.strip():
            return None
        return json.loads(input_string)
    except json.JSONDecodeError as e:
        send_error_response("Format JSON tidak valid: " + str(e))
        sys.exit(1)

def send_response(data):
    print(json.dumps({
        "status": "success",
        "data": data
    }))

def send_error_response(message):
    print(json.dumps({
        "status": "error",
        "message": message
    }))

def main():
    raw_payload = get_input_data()
    
    if not raw_payload:
        send_error_response("Tidak ada data dari Laravel.")
        sys.exit(1)
        
    try:
        # TODO: Pangill logika pemrosesan dari folder core/methods di sini
        # result = process(raw_payload)
        result = {"message": "Helo dari kbs engine!"}
        
        send_response(result)
        
    except Exception as e:
        send_error_response(f"Terjadi kesalahan: {str(e)}")

if __name__ == "__main__":
    main()
