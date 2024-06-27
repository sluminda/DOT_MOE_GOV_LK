import csv

# Define the CSV file path and the output SQL file path
csv_file_path = 'institutions_List.csv'
sql_file_path = 'institution.sql'

# Read the CSV file and generate the SQL insert statements
with open(csv_file_path, mode='r', encoding='utf-8') as file:
    csv_reader = csv.reader(file)
    header = next(csv_reader)  # Read the header row to get column names

    # Prepare the SQL insert statement template with column names from the CSV header
    insert_statement = f"INSERT INTO institutions ({', '.join(header)}) VALUES "

    # Initialize a list to hold the values
    values_list = []

    # Iterate through the CSV rows and format them as SQL values
    for row in csv_reader:
        values = []
        for i, value in enumerate(row):
            # Ensure numeric columns are not enclosed in quotes
            if header[i] in ['IsNationalSchool', 'SchoolType']:
                values.append(value)
            else:
                values.append(f"'{value.replace('\'', '\'\'')}'")  # Escape single quotes in values
        values_list.append(f"({', '.join(values)})")

    # Join all values with a comma
    values_str = ",\n".join(values_list)

    # Combine the insert statement with the values
    sql_query = insert_statement + values_str + ";"

    # Save the SQL query to a file
    with open(sql_file_path, mode='w', encoding='utf-8') as sql_file:
        sql_file.write(sql_query)

print(f"SQL insert statements have been written to {sql_file_path}")
