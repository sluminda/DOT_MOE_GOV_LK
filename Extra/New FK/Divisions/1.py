import csv

# Define the CSV file path and the output SQL file path
csv_file_path = 'division_List.csv'
sql_file_path = 'insert_division_data.sql'

# Read the CSV file and generate the SQL insert statements
with open(csv_file_path, mode='r', encoding='utf-8') as file:
    csv_reader = csv.reader(file)
    header = next(csv_reader)  # Skip the header row

    # Prepare the SQL insert statement template
    insert_statement = "INSERT INTO division (divcode, divisionname, distcode, zonecode, divisionname_si, divisionname_ta, status) VALUES "

    # Initialize a list to hold the values
    values_list = []

    # Iterate through the CSV rows and format them as SQL values
    for row in csv_reader:
        values = ", ".join(f"'{value}'" if i != 6 else value for i, value in enumerate(row))  # Ensure status is not enclosed in quotes
        values_list.append(f"({values})")

    # Join all values with a comma
    values_str = ",\n".join(values_list)

    # Combine the insert statement with the values
    sql_query = insert_statement + values_str + ";"

    # Save the SQL query to a file
    with open(sql_file_path, mode='w', encoding='utf-8') as sql_file:
        sql_file.write(sql_query)

print(f"SQL insert statements have been written to {sql_file_path}")
