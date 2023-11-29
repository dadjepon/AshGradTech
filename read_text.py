#pylint: disable = no-name-in-module, missing-module-docstring, line-too-long, trailing-whitespace
import google.auth 
from google.cloud import documentai

def online_process(file_path: str) -> documentai.Document:
    '''
    Args:
        project_id (str) : The Google Cloud Project

    Return:
        text (response): Extracted Text
    '''
    processor_id, project_id, location = "7e6b9cb13e2f136a", 866827155501, "us"
    opts = {"api_endpoint": f"{location}-documentai.googleapis.com"}

    credential_path = "ashgradcheck-e11866cd0200.json"

    credentials, _ = google.auth.load_credentials_from_file(
        scopes=["https://www.googleapis.com/auth/cloud-platform"], filename=credential_path, quota_project_id=project_id
    )
    # Instantiates a client
    documentai_client = documentai.DocumentProcessorServiceClient.from_service_account_file(
        client_options=opts, credentials=credentials, filename=credential_path)

    resource_name = documentai_client.processor_path(
        project_id, location, processor_id)

    # Read the file into memory
    with open(file_path, "rb") as file:
        file_content = file.read()

    # Load Binary Data into Document AI RawDocument Object
    raw_document = documentai.RawDocument(
        content=file_content, mime_type="application/pdf")

    # Configure the process request
    request = documentai.ProcessRequest(
        name=resource_name, raw_document=raw_document)

    # Use the Document AI client to process the sample form
    response = documentai_client.process_document(request=request)

    return response.document.text


# program driver
if __name__ == "__main__":
    FILE_PATH = "jakman_solutions_milestone_3.pdf"
    online_process(file_path=FILE_PATH)
