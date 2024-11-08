from django.shortcuts import render
from django.http import JsonResponse
import joblib
import os
from django.conf import settings
import pandas as pd

# Load the models (update the paths if needed)
random_forest_model_path = os.path.join(settings.BASE_DIR, 'loanassessment', 'models', 'random_forest_model.pkl')
decision_tree_model_path = os.path.join(settings.BASE_DIR, 'loanassessment', 'models', 'decision_tree_model.pkl')

print(f"Random Forest Model Path: {random_forest_model_path}")
print(f"Decision Tree Model Path: {decision_tree_model_path}")

try:
    random_forest_model = joblib.load(random_forest_model_path)
    decision_tree_model = joblib.load(decision_tree_model_path)
except Exception as e:
    print(f"Error loading models: {str(e)}")
    random_forest_model = None
    decision_tree_model = None

# Define preprocessing function
def preprocess_input_data(input_data):
    expected_features = {
        'state': input_data.get('state'),
        'crop': input_data.get('crop'),
        'season': input_data.get('season'),
        'area_units': float(input_data.get('area_units')),
        'production_units': float(input_data.get('production_units')),
        'average_area': 0.0,  # Default value if not provided
        'total_production': 0.0,
        'yield_value': 0.0,
        'annual_rainfall': 0.0,
        'min_price': 0.0,
        'max_price': 0.0,
        'modal_price': 0.0,
        'soil_index': 0.0,
        'production_per_hectare': 0.0,
    }
    input_df = pd.DataFrame([expected_features])
    print("Input DataFrame for prediction:", input_df)  # Debug print
    return input_df

# Main view
def loan_eligibility(request):
    if request.method == 'POST':
        # Collect input data from the form
        state = request.POST.get('state')
        crop = request.POST.get('crop')
        season = request.POST.get('season')
        area_units = request.POST.get('area_units')
        production_units = request.POST.get('production_units')
        model_choice = request.POST.get('model', 'random_forest')  # Default to 'random_forest' if not provided

        # Ensure all inputs are provided
        if not all([state, crop, season, area_units, production_units]):
            return JsonResponse({'error': 'All fields are required.'}, status=400)

        try:
            # Preprocess input data
            input_data = preprocess_input_data({
                'state': state,
                'crop': crop,
                'season': season,
                'area_units': area_units,
                'production_units': production_units
            })

            # Select the model based on user choice
            model = random_forest_model if model_choice == 'random_forest' else decision_tree_model

            # Ensure the model is loaded properly
            if model is None:
                return JsonResponse({'error': 'Model not loaded properly.'}, status=500)

            # Make prediction
            prediction = model.predict(input_data)  # Ensure input_data format matches model's training data
            loan_eligibility = 'Eligible' if prediction[0] == 1 else 'Not Eligible'
            return JsonResponse({'loan_eligibility': loan_eligibility})
        
        except Exception as e:
            # Capture detailed error message and return it
            print(f"Prediction Error: {str(e)}")  # Print error for debugging
            return JsonResponse({'error': f'Prediction failed: {str(e)}'}, status=500)

    return render(request, 'loanassessment/loan_form.html')

    # import pandas as pd

    # def preprocess_input_data(input_data, training_columns):
    #     # Initial dictionary with user input
    #     data_dict = {
    #         'state': input_data.get('state', ''),
    #         'crop': input_data.get('crop', ''),
    #         'average_area': float(input_data.get('average_area', 0)),
    #         'total_production': float(input_data.get('total_production', 0)),
    #         'season': input_data.get('season', ''),
    #         'area_units': float(input_data.get('area_units', 0)),
    #         'production_units': float(input_data.get('production_units', 0)),
    #         'yield_value': float(input_data.get('yield_value', 0)),
    #         'annual_rainfall': float(input_data.get('annual_rainfall', 0)),
    #         'min_price': float(input_data.get('min_price', 0)),
    #         'max_price': float(input_data.get('max_price', 0)),
    #         'modal_price': float(input_data.get('modal_price', 0)),
    #         'soil_index': float(input_data.get('soil_index', 0)),
    #         'production_per_hectare': float(input_data.get('production_per_hectare', 0))
    #     }
        
    #     # Convert to DataFrame
    #     input_df = pd.DataFrame([data_dict])
        
    #     # One-hot encode categorical columns as in training
    #     input_df = pd.get_dummies(input_df, columns=['state', 'crop', 'season'])
        
    #     # Add any missing columns from the training data, filling with 0
    #     for col in training_columns:
    #         if col not in input_df.columns:
    #             input_df[col] = 0

    #     # Ensure the column order matches training data
    #     input_df = input_df[training_columns]
        
    #     return input_df

    # # # Store training column names after preprocessing
    # # training_columns = X_train.columns.tolist()



    # # Example form data
    # form_data = {
    #     'state': 'west bengal',
    #     'crop': 'soybean',
    #     'average_area': 148.25,
    #     'total_production': 8796.0,
    #     'season': 'kharif',
    #     'area_units': 148.25,
    #     'production_units': 8796.0,
    #     'yield_value': 0.66,
    #     'annual_rainfall': 1720.56,
    #     'min_price': 3250.0,
    #     'max_price': 3300.0,
    #     'modal_price': 3275.0,
    #     'soil_index': 85.18,
    #     'production_per_hectare': 59.33
    # }

    # # Preprocess the input data to match the training format
    # input_df = preprocess_input_data(form_data, training_columns)

    # # Make a prediction
    # try:
    #     prediction = rf_model.predict(input_df)
    #     print("Loan Eligibility Prediction:", prediction)
    # except Exception as e:
    #     print("Error in prediction:", e)
