import pandas as pd

# Read the Excel file
excel_file = 'Institutes_Final.xlsx'  # Replace with your Excel file name
df = pd.read_excel(excel_file, dtype=str)  # Read all data as strings to preserve formatting

# Generate the INSERT INTO SQL queries
table_name = 'institutions'
columns = df.columns.tolist()

insert_queries = []

for index, row in df.iterrows():
    values = []
    for col in columns:
        value = row[col]
        if pd.isna(value):
            values.append('NULL')
        else:
            # Ensure values are treated as strings and properly escaped
            cleaned_value = str(value).strip().replace("'", "''")
            values.append(f"'{cleaned_value}'")
    insert_query = f"INSERT INTO `{table_name}` ({', '.join([f'`{col}`' for col in columns])}) VALUES ({', '.join(values)});"
    insert_queries.append(insert_query)

# Write the queries to a .sql file
sql_file = 'Institutes_Final.sql'
with open(sql_file, 'w') as file:
    file.write('\n'.join(insert_queries))

print(f"SQL insert queries have been written to {sql_file}")
