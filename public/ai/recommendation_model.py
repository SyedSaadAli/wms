# public/ai/recommendation_model.py

import pandas as pd
from sklearn.metrics.pairwise import cosine_similarity
from sklearn.preprocessing import StandardScaler
import sys
import os

user_id = sys.argv[1]

venue_file = 'public/ai/venues.csv'
survey_file = f'public/ai/user_survey_{user_id}.csv'
output_file = f'public/ai/recommended_venues_{user_id}.csv'

venues_df = pd.read_csv(venue_file)
survey_df = pd.read_csv(survey_file)

# Label encode categorical fields
for col in ['event_type', 'ambience']:
    venues_df[col] = venues_df[col].astype('category').cat.codes
    survey_df[col] = survey_df[col].astype('category').cat.codes

# Standardize data
scaler = StandardScaler()
venue_features = scaler.fit_transform(venues_df[['event_type', 'guest_capacity', 'ambience']])
user_features = scaler.transform(survey_df[['event_type', 'guest_capacity', 'ambience']])

# Compute similarity
similarity = cosine_similarity(user_features, venue_features)
top_indices = similarity[0].argsort()[-10:][::-1]
recommended_venues = venues_df.iloc[top_indices]

# Save recommendations
recommended_venues.to_csv(output_file, index=False)
