import unittest
from unittest import mock
from unittest.mock import patch
from read_text import process_document_sample

class TestProcessDocumentSample(unittest.TestCase):

    @patch("google.auth.load_credentials_from_file")
    @patch("google.cloud.documentai.DocumentProcessorServiceClient")
    @patch("builtins.open", new_callable=unittest.mock.mock_open, read_data="fake_image_content")
    def test_process_document_sample(self, mock_open, mock_client, mock_load_credentials):
        # Mock data
        project_id = "fake_project_id"
        location = "fake_location"
        processor_id = "fake_processor_id"
        file_path = "/fake/path/to/file.pdf"
        mime_type = "application/pdf"
        field_mask = "fakeFieldMask"
        processor_version_id = "fake_processor_version_id"

        # Mock credentials
        mock_load_credentials.return_value = ("fake_credentials", None)

        # Mock DocumentProcessorServiceClient
        mock_client_instance = mock_client.return_value
        mock_client_instance.processor_version_path.return_value = "fake_processor_version_path"
        mock_client_instance.processor_path.return_value = "fake_processor_path"

        # Mock ProcessRequest result
        mock_result = mock_client_instance.process_document.return_value
        mock_result.document.text = "fake_result_text"

        # Run the function
        result_text = process_document_sample(
            project_id=project_id,
            location=location,
            processor_id=processor_id,
            file_path=file_path,
            mime_type=mime_type,
            field_mask=field_mask,
            processor_version_id=processor_version_id
        )

        # Assertions
        mock_open.assert_called_once_with(file_path, "rb")
        mock_client.assert_called_once_with(client_options=mock.ANY, credentials="fake_credentials")
        mock_client_instance.process_document.assert_called_once_with(request=mock.ANY)

        # Ensure the result is as expected
        self.assertEqual(result_text, "fake_result_text")


if __name__ == '__main__':
    unittest.main()
