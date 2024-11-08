from django.shortcuts import render
from django.http import JsonResponse
import pandas as pd
from sklearn.ensemble import RandomForestClassifier
from sklearn.tree import DecisionTreeClassifier
from sklearn.preprocessing import OneHotEncoder
from sklearn.compose import ColumnTransformer
from sklearn.pipeline import Pipeline
from sklearn.metrics import accuracy_score
import os
from django.conf import settings

from django.shortcuts import render

def index(request):
    return render(request, 'index.html')

def train_and_predict_model(request):
    if request.method == 'POST':
        # Collect input data from the form
        form_data = {
            'state': request.POST.get('state'),
            'crop': request.POST.get('crop'),
            'season': request.POST.get('season'),
            'area_units': request.POST.get('area_units'),
            'production_units': request.POST.get('production_units'),
            'average_area': request.POST.get('average_area'),
            'total_production': request.POST.get('total_production'),
            'yield_value': request.POST.get('yield_value'),
            'annual_rainfall': request.POST.get('annual_rainfall'),
            'min_price': request.POST.get('min_price'),
            'max_price': request.POST.get('max_price'),
            'modal_price': request.POST.get('modal_price'),
            'soil_index': request.POST.get('soil_index'),
            'production_per_hectare': request.POST.get('production_per_hectare')
        }

        # Ensure all required inputs are provided
        if not all(form_data.values()):
            return JsonResponse({'error': 'All fields are required.'}, status=400)

        try:
            # Load dataset for model training
            dataset_path = os.path.join(settings.BASE_DIR, 'loanassessment', 'data', 'loan_data.csv')
            df = pd.read_csv(dataset_path)

            # Separate features (X) and target (y)
            X = df.drop(columns=['loan_eligibility'])  # Exclude target column for features
            y = df['loan_eligibility']  # Target variable

            # Define categorical and numerical columns
            categorical_cols = ['state', 'crop', 'season']
            numerical_cols = X.select_dtypes(include=['float64', 'int64']).columns.tolist()

            # Preprocessing pipeline
            preprocessor = ColumnTransformer(
                transformers=[
                    ('num', 'passthrough', numerical_cols),
                    ('cat', OneHotEncoder(handle_unknown='ignore'), categorical_cols)
                ]
            )

            # Model selection (based on the model type provided by the user, default to random forest)
            model_choice = request.POST.get('model', 'random_forest')
            if model_choice == 'random_forest':
                model = RandomForestClassifier(n_estimators=100, random_state=42)
            else:
                model = DecisionTreeClassifier(random_state=42)

            # Create a pipeline with preprocessing and the chosen model
            pipeline = Pipeline(steps=[('preprocessor', preprocessor), ('classifier', model)])

            # Train the model
            pipeline.fit(X, y)

            # Preprocess the input data for prediction (same as training data)
            input_df = pd.DataFrame([{
                'state': form_data['state'],
                'crop': form_data['crop'],
                'season': form_data['season'],
                'area_units': float(form_data['area_units']),
                'production_units': float(form_data['production_units']),
                'average_area': float(form_data['average_area']),
                'total_production': float(form_data['total_production']),
                'yield_value': float(form_data['yield_value']),
                'annual_rainfall': float(form_data['annual_rainfall']),
                'min_price': float(form_data['min_price']),
                'max_price': float(form_data['max_price']),
                'modal_price': float(form_data['modal_price']),
                'soil_index': float(form_data['soil_index']),
                'production_per_hectare': float(form_data['production_per_hectare']),
            }])

            # Use the preprocessor to transform the input data
            preprocessed_input = pipeline.named_steps['preprocessor'].transform(input_df)

            # Make prediction
            prediction = pipeline.named_steps['classifier'].predict(preprocessed_input)

            # Return prediction result
            loan_eligibility = 'Eligible' if prediction[0] == 1 else 'Not Eligible'
            return JsonResponse({'loan_eligibility': loan_eligibility})

        except Exception as e:
            print(f"Prediction Error: {str(e)}")
            return JsonResponse({'error': f'Prediction failed: {str(e)}'}, status=500)

    # Render the form if GET request
    return render(request, 'loan_form.html')  # This should render the loan form page

