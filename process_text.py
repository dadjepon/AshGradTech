import json
import re


def parse_transcript(transcript) -> json:
    transcript_data = {}
    current_semester = None
    current_course = {}

    # Regular expressions for grades and credits
    grade_pattern = re.compile(r"([A-EP][\+\-]?)$")
    credits_pattern = re.compile(r"^(?:\d+(?:\.\d+)?)$")
    course_title_pattern = re.compile(r"^[A-Za-z0-9\s\+\-'|?&/:,]+$")

    for line in transcript.splitlines():
        line = line.strip()

        # Identify semester
        if re.match(r'^Semester ?\d', line):
            current_semester = line
            transcript_data[current_semester] = {}

        # Identify course code
        elif re.match(r"(?:\w{2}\d{3}|\w+\s\d{3}|\w+\d+)", line):
            current_course_code = line
            current_course = {"course_code": current_course_code}
            transcript_data[current_semester][current_course_code] = current_course

        # Extract course data
        elif course_title_pattern.match(line) and current_course:
            if "course_title" not in current_course and len(line) > 1:
                current_course["course_title"] = line
                # Check if the line contains numeric values
                if any(char.isdigit() or char.isdecimal() for char in line):
                    # credits_match = re.search(r"(0\.5|0|1)", line)
                    current_course["credits"] = credits_match.group() #if credits_match else None
                    current_course["grade"] = None
                else:
                    current_course["credits"] = "0.5"
                    current_course["grade"] = None
            else:
                # Use the separate regex patterns for grades and credits
                grade_match = grade_pattern.search(line)
                credits_match = credits_pattern.search(line)

                if grade_match and grade_match.group() != "E":
                    current_course["grade"] = grade_match.group()
                if credits_match:
                    current_course["credits"] = credits_match.group()

    return (json.dumps(transcript_data, indent=4))