import json
import requests
import APIFunctions
import pprint 
import random 

#--- api url , key, and specific request TEST---
api_url = ("https://www.thecocktaildb.com/api/json/v2/9973533/")
request = ("search.php?s=gin")

# --- FUNCTION : format JSON data to view ONLY --- 
def jprint(obj):
	text = json.dumps(obj, sort_keys=True, indent=4)
	print(text)
#------------------------------------------------------

# --- Alcoholic or non alchoholic function --- 
def alcoholic(ans):
	#ans = ans.casefold()
	if ans == "nonalcoholic":
		#Alcoholic_dict = {}
		request = ("filter.php?a=Non_Alcoholic")
		response = requests.get(api_url+request)
		data = response.json()
		return data
	elif ans == 'alcoholic': 
		#Alcoholic_dict = {}
		request = ("filter.php?a=Alcoholic")
		response = requests.get(api_url+request)
		data = response.json()
		return data

# --- Category function --- 
def category(ans, ans2):
	drink_counter = 0
	category_array = []
	category_data = alcoholic(ans)
	for drink in category_data["drinks"]:
		request_id = category_data["drinks"][drink_counter]["idDrink"]
		request = ("lookup.php?i="+request_id)
		category_response = requests.get(api_url+request)
		category_response_data = category_response.json()
		if category_response_data['drinks'][0]["strCategory"] == ans2:
			category_array.append(category_response_data['drinks'][0]['idDrink'])
		drink_counter += 1
	#print(category_array)
	return category_array

def ingrediants(ans, ans2, ans3):
	results_array = [] 
	compare_array = [] 
	final_array = [] 
	ingrediants_data = category(ans, ans2)
	request = ("filter.php?i="+ans3)
	ingrediants_response = requests.get(api_url+request)
	ingrediants_response_data = ingrediants_response.json() #everything with desired ingrediant
	if ingrediants_response_data['drinks'] == "None Found":
		for noMatchDrink in ingrediants_data: 
			request = ("lookup.php?i="+noMatchDrink)
			final_response = requests.get(api_url+request)
			final_data = final_response.json()
			for x in final_data['drinks']: #goes through drinks of previous 2 Q's to and gets info desired ingrediants doesnt appear
				final_array.append(x['idDrink'])
				final_array.append(x['strDrink'])
				final_array.append(x['strDrinkThumb'])
		final_array.insert(0,"False List")		
		return final_array 
	else: 
		for i in ingrediants_response_data['drinks']:
			compare_array.append(i['idDrink'])
		for x in ingrediants_data: # does the comparison and filters to get drinks that match request
			if x in compare_array:
				results_array.append(x)
		if len(results_array) > 0:
			for drink in results_array:
				request = ("lookup.php?i="+drink)
				final_response = requests.get(api_url+request)
				final_data = final_response.json()
				for y in final_data['drinks']: #goes through VALID results and gets info
					final_array.append(y['idDrink'])
					final_array.append(y['strDrink'])
					final_array.append(y['strDrinkThumb'])
		final_array.insert(0,"Correct Array")
		print(final_array)
		return(final_array)

def popular_drinks(body):
	request = ("popular.php")
	response = requests.get(api_url+request)
	popular_drinks_selection = response.json()
	return popular_drinks_selection

def howtomake(id):
	howtomake_array = []
	request = ("lookup.php?i="+ id)
	response = requests.get(api_url+request)
	howtomake_data = response.json()
	howtomake_array.append(howtomake_data['drinks'][0]['strDrinkThumb'])
	howtomake_array.append(howtomake_data['drinks'][0]['strInstructions'])
	return howtomake_array

# --- Yelp API --- 

yelp_key = "bc6utOfTROBnI9OqigAJDY5Kh0nY7K5y3h5TCMWCobHpq0DZZVTj1QsdMw0ZTgZikrk3sutTE5waspolZnH-YoCJWuut0J_Sagvf3ZPbABUxmWDmnJiZ4tMpQBh5XXYx"
headers = {'Authorization': 'Bearer %s' % yelp_key}
yelp_url='https://api.yelp.com/v3/businesses/search'

def planmynight(zip):
	# random bar based on zipcode
	random_bar_counter = 0 
	random_planmynight_array = []
	params = {'term':'bar','location' : zip}
	req = requests.get(yelp_url, params=params, headers=headers)
	yelp_data = json.loads(req.content)
	while random_bar_counter <= 4:
		random_bar = random.choice(yelp_data['businesses'])
		random_planmynight_array.append(random_bar)
		random_bar_counter += 1 
	# random drink 
	request = ("randomselection.php")
	response = requests.get(api_url+request)
	random_drinks = response.json()
	random_planmynight_array.append(random_drinks)
	pprint.pprint(random_planmynight_array)
	return random_planmynight_array


