import json
from process_text import parse_transcript
from read_text import process_document_sample as rd
from course_reqs import *

class Student:

    def __init__(self, transcript, level, major, year_group, semester):
        self.transcript = transcript 
        self.level = level
        self.major = major
        self.year_group = year_group
        self.semester = semester

    def evaluate_transcript(self):
        # Calculate credits from transcript
        total_credits= 0
        failed_courses = []
        status = ""
        # num_semesters = sum(1 for semester in transcript.keys() if re.match(r'^Semester ?\d', semester))
        
        for semester in self.transcript:
            for course_code in self.transcript[semester]:
                grade = self.transcript[semester][course_code]["grade"]
                
                if grade in ["A", "A+", "B", "B+", "C", "C+", "D+"]:
                    credits = float(self.transcript[semester][course_code]["credits"])
                    total_credits += credits
                
                elif grade in ["D", "E"]:
                    failed_courses.append(self.transcript[semester][course_code]["course_title"])
        
        requirements = self.major.get_requirements(self.year_group, self.level, self.semester)
        if total_credits >= requirements:
            status = "On Track"
        else: 
            status = "Not on track"

        progress = {
            "total_credits": total_credits,
            "failed": failed_courses,
            "track_status": status
        }
        return progress


if __name__ == "__main__":
    FILE_PATH = "trans.pdf"
    output = rd(
        project_id = "866827155501",
        location = "us",
        processor_id = "61abf4ec482095a0",
        file_path = "trans.pdf",
        mime_type = "application/pdf",
        field_mask = "text, layout",
        processor_version_id = "ad8664f46cdd7d84"
    )
    transcript = json.loads(parse_transcript())
    # print(transcript)

    major = CS()
    level = 3 #current level
    semester = 1 #current semester
    year_group = 2024 #year of graduation

    student = Student(transcript, level, major, year_group, semester)
    # reqs = student.major.get_requirements(year_group=year_group, level=level, semester=semester)
    credits = student.evaluate_transcript()

    print(
    f"""
    Total Credits Attained = {credits["total_credits"]}
    Failed Courses = {credits["failed"], "Number of failed courses: ", len(credits["failed"])}
    Audit Status = {credits["track_status"]}
    """)