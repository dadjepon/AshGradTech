from typing import Optional
import google.auth
from google.api_core.client_options import ClientOptions
from google.cloud import documentai  # type: ignore


def process_document_sample(
    project_id: str,
    location: str,
    processor_id: str,
    file_path: str,
    mime_type: str,
    field_mask: Optional[str] = None,
    processor_version_id: Optional[str] = None,
) -> None:
    # You must set the `api_endpoint` if you use a location other than "us".
    opts = ClientOptions(api_endpoint=f"{location}-documentai.googleapis.com")

    credential_path = "ashgradcheck-e11866cd0200.json"

    credentials, _ = google.auth.load_credentials_from_file(
        scopes=["https://www.googleapis.com/auth/cloud-platform"], filename=credential_path, quota_project_id=project_id
    )

    client = documentai.DocumentProcessorServiceClient(client_options=opts, credentials=credentials)

    if processor_version_id:
        name = client.processor_version_path(
            project_id, location, processor_id, processor_version_id
        )
    else:
        # The full resource name of the processor, e.g.:
        # `projects/{project_id}/locations/{location}/processors/{processor_id}`
        name = client.processor_path(project_id, location, processor_id)

    # Read the file into memory
    with open(file_path, "rb") as image:
        image_content = image.read()

    # Load binary data
    raw_document = documentai.RawDocument(content=image_content, mime_type=mime_type)


    # Configure the process request
    request = documentai.ProcessRequest(
        name=name,
        raw_document=raw_document,
        field_mask=field_mask,
        # process_options=process_options,
    )

    result = client.process_document(request=request)

    return result.document.text

