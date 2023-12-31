import functions_framework
import os, tempfile, json
from flask import Flask, request, jsonify
from flask_cors import CORS

from course_reqs import CS, BA, MIS, EE, ME, CE
from degree_auditer import Student
from read_text import process_document_sample as pds
from process_text import parse_transcript as pt

from google.cloud import firestore
from firebase_admin import credentials, firestore, initialize_app

# Initialize Firestore Database
credential = credentials.Certificate('ashgradcheck-e11866cd0200.json')
default_app = initialize_app(credential)

#initializing the firestore client with the project ID
db = firestore.client()


app = Flask(__name__)
CORS(app)

@functions_framework.http
def entry_point(request):
    if 'audit' in request.path and request.method == "POST":
        return audit_transcript()

@app.route("/audit", methods=["POST"])
def audit_transcript():
    # Ensure that the required fields are present in the request
    if "transcript" not in request.files:
        return "Incomplete transcript", 400
    elif "major" not in request.form:
        return "Incomplete major", 400
    elif "year_group" not in request.form:
        return "Incomplete year", 400
    elif "semester" not in request.form:
        return "Incomplete semester", 400

    #extract details from reponse body
    transcript_file = request.files["transcript"]
    major = request.form["major"]
    year_group = int(request.form["year_group"])
    semester = int(request.form["semester"])

    if not transcript_file:
        return "No transcript file found", 400

    # Create a temporary file
    temp_fd, temp_filename = tempfile.mkstemp(suffix=".pdf", prefix="transcript_", dir=tempfile.gettempdir())
    os.close(temp_fd)

    print("Temp Filename: ", temp_filename)

    # Save uploaded file to the temporary file
    transcript_file.save(temp_filename)
    # Extract text
    output = pds(
        project_id="866827155501",
        location="us",
        processor_id="61abf4ec482095a0",
        file_path=temp_filename,
        mime_type="application/pdf",
        field_mask="text, layout",
        processor_version_id="ad8664f46cdd7d84"
    )
    # Delete temp file after
    os.remove(temp_filename)

    transcript_json = json.loads(pt(output))

    # Choose the major based on the provided string
    if major == "CS":
        major_obj = CS()
    elif major == "MIS":
        major_obj = MIS()
    elif major == "BA":
        major_obj = BA()
    elif major == "EE":
        major_obj = EE()
    elif major == "ME":
        major_obj = ME()
    elif major == "CE":
        major_obj = CE()
    else:
        return "Invalid major provided", 400

    # Initialize Student instance with provided details
    student = Student(transcript_json, major_obj, year_group, semester)
    credits = student.evaluate_transcript()

    response = jsonify(credits)

    #CORS config
    response.headers.add("Access-Control-Allow-Origin", "*")
    return response


@app.route("/email", methods=['POST'])  
def send_email():
    email = "aaron.tamakloe@ashesi.edu.gh"

    student_name = request.json['name']
    credits = request.json['credits']
    year_group = request.json['year_group']
    st_email = request.json['email']
    
    data = {
      "to": email,
      "message": {
        "subject": "AshGradCheck: Degree Audit",
        "text": f"""
    Hello Emmanuel,   
    {student_name}, a member of the class of {year_group} just completed their degree audit on AshGradCheck.
    They have attained {credits} credits so far. AshGradCheck found that they are not on track.
    Kindly follow up to assist getting them back on track.

    Their email is {st_email}.

    Best,
    AshGradCheck"""
      }
    }

    db.collection('mail').add(data)
    
    return "Email Sent", 200

if __name__ == "__main__":
    app.run(debug=True)
