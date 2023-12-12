import unittest
from unittest.mock import MagicMock
from datetime import datetime
from degree_auditer import Student

class TestStudentEvaluation(unittest.TestCase):

    def setUp(self):
        # Mock transcript data for testing
        self.mock_transcript = {
            'Semester 1': {
                'CS101': {'grade': 'A', 'credits': '1', 'course_title': 'Introduction to CS'},
                'MATH101': {'grade': 'B+', 'credits': '1', 'course_title': 'Calculus I'}
            },
            'Semester 2': {
                'CS201': {'grade': 'C', 'credits': '1', 'course_title': 'Data Structures'},
                'MATH102': {'grade': 'D', 'credits': '1', 'course_title': 'Calculus II'}
            }
            # Add more semesters and courses for testing
        }

        # Mock the major requirements
        self.mock_major = MagicMock()
        self.mock_major.get_requirements.return_value = 8.5

        # Initialize Student instance for testing
        self.test_student = Student(
            transcript=self.mock_transcript,
            major=self.mock_major,
            year_group=2022,  # Set a random year group
            semester=1  # Set a random semester
        )


    def test_evaluate_transcript(self):
        # Set the total credits to be less than requirements for not on-track status
        self.test_student.major.get_requirements.return_value = 5
        result = self.test_student.evaluate_transcript()
        self.assertEqual(result['track_status'], 'Not on track')

    def test_evaluate_transcript_failed_courses(self):
        # Set one or more failed courses in the transcript
        self.mock_transcript['Semester 3'] = {'CS301': {'grade': 'E', 'credits': '1', 'course_title': 'Advanced CS'}}
        result = self.test_student.evaluate_transcript()
        self.assertGreater(len(result['failed']), 0)

if __name__ == '__main__':
    unittest.main()
