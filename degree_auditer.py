import json
import datetime
from datetime import datetime
from process_text import parse_transcript
from read_text import process_document_sample as rd
from course_reqs import *

class Student:

    def __init__(self, transcript, major, year_group, semester):
        self.transcript = transcript 
        self.level = 4 - (year_group - datetime.now().year)
        self.major = major
        self.year_group = year_group
        self.semester = semester

    def evaluate_transcript(self):
        # Calculate credits from transcript
        total_credits= 0
        failed_courses = []
        status = ""
        
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