# AgriLoan AI

## Description

Imagine a world where small-scale farmers, the backbone of India’s agricultural economy, are no longer hindered by limited financial access, which they are currently denied due to the lack of formal financial records and credit history or collateral. AgriLoan is about transforming this vision into reality.

AgriLoan is an AI-driven platform designed to improve financial access for small-scale farmers by offering a new way to assess loan eligibility, focusing on farmers' actual productivity and agricultural data—like crop yields, rainfall patterns, soil indexes—rather than conventional credit scores. By utilizing machine learning, the platform classifies whether a given farmer is eligible for a loan or not, enabling financial institutions to make better-informed decisions and extend financial support to farmers who have been earlier neglected by traditional banking systems, thus empowering them to achieve sustainable growth and economic stability.

Integration with Vultr’s scalable cloud services, AgriLoan ensures secure and real-time analysis of data across vast regions, empowering financial inclusion for farmers. Ultimately enabling farmers to adopt sustainable practices, invest in advanced techniques, and increase productivity, fostering both agricultural and economic growth in rural communities.

This documentation provides detailed technical insights into the system architecture, key components, and modules, along with setup and usage instructions.

## Contents

1. [System Architecture and Design](#system-architecture-and-design)
2. [Explanation of Key Components and Modules](#explanation-of-key-components-and-modules)
3. [API Documentation](#api-documentation)
4. [Setup and Usage Instructions](#setup-and-usage-instructions)

---

## System Architecture and Design

AgriLoan utilizes an AI-driven architecture to conduct risk assessments and manage large volumes of agricultural data while ensuring scalability, security, and real-time processing. The system can be divided into several key components:

### 1. Data Ingestion Layer:

**Data Source:**
- **Farmer-Provided Data:** This includes basic information like name, address, landholding size, crop types, and farming practices.
- **Third-Party Data:** This can include production data, soil data, and market prices, sourced from APIs or directly from government agencies.

**Data Storage:**
- Utilizes Vultr Object Storage to store large datasets required for prediction and MySQL, a Relational Database, to store structured data like farmer profiles.

### 2. Data Processing Layer:

- **Data Cleaning and Preprocessing:** Cleaning and standardizing data to ensure consistency and accuracy. Handling missing values and outliers. Feature engineering to extract relevant information from raw data.
- **Machine Learning Model:** Training a machine learning model utilizing decision trees and random forest on historical data to predict creditworthiness based on various factors like crop yield, market trends, etc. Deploying the trained model to Vultr's Compute Instances for real-time predictions.

### 3. Application Layer:

**Core Architecture:**
- **Frontend:** Built using modern web technologies (HTML, CSS, JavaScript). The frontend offers an intuitive and user-friendly interface where farmers can register, input their farming data, and track their loan applications. The frontend is responsible for gathering user input, interacting with the backend API, and displaying the results (i.e., loan eligibility prediction).
  
- **Backend:** Developed using Python and Django. The backend handles data processing, AI model predictions, and API integrations. It communicates with databases, processes loan applications, and returns whether the farmer is eligible for a loan or not.

- **AI/ML Algorithms:** The core of the AI engine uses machine learning algorithms to assess risk based on agricultural data. These algorithms are trained on various datasets, including crop yields, rainfall patterns, and soil data, to classify the farmers based on eligibility accurately.

- **Cloud Infrastructure:** Hosted on Vultr’s cloud services, AgriLoan leverages high-performance cloud servers, object storage, and third-party API integrations to provide scalable and efficient data processing.

**Data Flow and User Interaction:**
1. **Farmer Registration and Data Input:** Farmers log in and input basic data regarding their crops and land.
2. **Data Processing:** The system aggregates and processes input data using AI/ML algorithms and classifies the farmers based on eligibility.
3. **Loan Assessment:** Based on the profile, financial institutions are provided with the loan eligibility results and recommendations.
4. **Loan Disbursement:** Once approved, the system facilitates the loan application process for the farmer, providing educational resources to help with financial literacy.

### 4. Infrastructure Layer:
**Vultr Cloud Services:**
- **Compute Instances:** For hosting the web application, API servers, and machine learning models.
- **Object Storage:** For storing large datasets.
- **Database:** For storing structured data.
- **Load Balancing:** To distribute traffic across multiple instances for scalability.
- **CDN:** To improve website performance and reduce latency.

---

## Explanation of Key Components and Modules

### 1. AI-Powered Risk Assessment:

- **Data Collection:** Gather input from various sources like crop yield reports, market data, and soil information.
- **Model Training:** Utilizes historical data to train machine learning models using algorithms like Random Forest and Decision Trees to evaluate loan risk.
- **Prediction Engine:** Predicts the eligibility of the farmer based on input data.

### 2. Data Integration:
- **Vultr Object Storage:** Stores large datasets such as crop yield data, soil analysis, and market data. Ensures secure and scalable access to data.

### 3. Frontend and Backend:
- **Frontend:** Provides intuitive forms for data entry and dashboards to track loan application statuses.
- **Backend:** Python and Django backend that handles all logic, including AI model integration, data aggregation, loan risk assessment, and user authentication.

---

## API Documentation

### 1. Authentication:
- **POST /login:** Authenticates a user and returns a session token.
- **POST /register:** Registers a new farmer and stores their data in the database.

### 2. Data Collection:
- **GET /weather:** Fetches weather data for a specified region using an integrated weather API.
- **GET /crop-data:** Fetches historical crop yield data from relevant sources (e.g., government databases).

### 3. Loan Assessment:
- **POST /assess-loan:** Submits farmer data and returns a loan eligibility result based on the AI model’s prediction (returns Farm Credit Score).
- **GET /loan-status:** Returns the current status of the loan application, including approval/rejection and disbursement details.

### 4. Educational Resources:
- **GET /resources:** Fetches a list of educational materials for farmers on financial literacy, loan management, and budgeting.

---

## Setup and Usage Instructions

### 1. Prerequisites:
- Python 3.8+
- Django framework for backend
- Numpy, Pandas, and Scikit-learn for machine learning models
- Vultr Cloud Account for hosting the platform
- Third-Party API Keys (for data integrations)

### 2. Setting up the Development Environment:

1. **Clone the Repository:**
   Open a terminal and enter the following commands to clone the project repository and navigate into the project directory:
   ```bash
   git clone https://github.com/YashikaGupta09/AgriLoan_AI
   cd AgriLoan_AI
2. **Install Backend Dependencies:**
    In the terminal, navigate to the backend directory and install the required packages:
    ```bash
    cd backend
    pip install -r requirements.txt
3. **Run the backend:**
Start the backend server by running the following command:
    ```bash
    python app.py

### 3.  Running the Application:
- Access the platform via http://localhost:8000
- API requests can be made to the backend endpoints as specified in the API documentation.
- Farmers can sign up, input their data, and apply for loans.

---

## Conclusion

AgriLoan is transforming how small-scale farmers access loans, offering a path toward financial inclusion. By utilizing AI and scalable cloud infrastructure, the platform provides real-time, data-driven loan assessments that can help farmers improve their productivity and achieve sustainable growth. Through this platform, we aim to not only address the financial challenges faced by farmers but also foster rural economic development.
