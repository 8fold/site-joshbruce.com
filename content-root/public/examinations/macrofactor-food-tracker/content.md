# MacroFactor, food tracker

{!! dateblock !!}

I learned about [MacroFactor](https://macrofactorapp.com) while watching a [Jeff Nippard](https://m.youtube.com/@JeffNippard) video (don’t remember which one). In it he gave a disclaimer that he is a part owner of the company that makes the app. 

It uses a tiered subscription model with the first month free.

From the website, the app has 6 marketed features:

- fast food logging,
- nutrition coach,
- energy expenditure,
- micronutrient tracking,
- progress photos and body metrics, and
- widgets.

Let’s summarize each.

## Fast food logging

This is how you enter foods you consume throughout the day. The creators state that they created a measuring system for speed, looking at how many discrete actions are required to log an item and how quickly the food database resolves to something meaningful for the user. This measurement index was used for the design of the app to result in the fastest food logger on the market.

The logger has the following methods for logging food:

- barcode scanner,
- search,
- quick add,
- AI Describe,
- custom, and
- recipes

The barcode scanner uses your camera to scan a barcode on a food item. Search let’s you type a food in. Quick add will let you plug in estimated calories and macronutrients without choosing a specific food. AI lets you describe a meal and the app will derive individual food items based on the description given. The Custom method lets you enter nutrition information to your local database. Recipes is basically a combination of the first four and the last.

The first four features of the food logger are really about searching. The fifth is about creating a custom entry in the local database. Recipes allow you to combine a number of foods in the database to create a new compound entry.

Another aspect of the food logger that improves search speed is that it will remember the time of day that you’ve repeatedly logged a food and will show those foods at the top of the list, followed by your latest search. So, you may find you don’t actually need to type in a search if you eat similar foods (or recipes) at similar time or just eating the same foods frequently. You can scroll instead of typing.

The food database is compiled from “vetted research databases” and “verified user-submitted entries.” This ensures the accuracy of the macronutrient and micronutrient details for each food. This is mainly in contrast to other apps that rely heavily on crowdsourcing and not verifying (or modifying) the crowdsourced data.

It’s possible to meal plan ahead of time with food logger as well. And it appears that each entry becomes its own snapshot. 

For example, if you create a recipe, enter the recipe on multiple days, then modify the recipe, the entries made with unmodified recipe aren’t changed. While this increases storage requirements it maintains data integrity.

### Micronutrient tracking

I’m putting this as a sub-feature of the food logger because the app appears to have two primary features:

1. the food logger, and
2. the nutrition coach.

The only way to view your micronutrient intake is via the food logger. As of the writing, you go to the food log, click the hamburger menu, and select “Go to nutrition overview.”

Here you can see calories, macros, and micros. Further, you can toggle to see how much each food contributed to each. Finally, you can see or set targets.

## Nutrition coach

The nutrition coach is a dashboard and wizard you reach via the “Strategy” menu option.

First you’ll either create or edit your goal regarding weight. There are three options; gain, maintain, or lose. If you choose to maintain, the app will ask you what weight you’d like to maintain (you can drag left and right). If you choose gain or lose, it will ask what weight you want to maintain, and tell it how fast you want to get there.

Once the app knows your goal, you can move to the programming wizard.

The wizard offers three styles; the app does all the work, you do all the work, and something in between.

The first style offers three diets to choose from; balanced, low-fat, low-carb, and keto. You can choose two caloric floors; the absolute least amount of caloric intake the app will suggest. There are four training options; none, lifting, cardio, and lifting with cardio. For calorie distribution you can set high and low calorie days or have the app distribute calories evenly. You tell the app how much protein you would like to consume; low, moderate, high, and extra high. At the end of the wizard, you’re presented with the recommended program.

The second style gives you the ability to the app your caloric intake, protein, and fat-carb ratio for each day of the week. So, if you have full fasting days or similar, this may be your best option. Once you’ve set each day of the week, you can start the program.

The third style gives you option to set the same values for each day of the week or day-by-day. In either case, you’re going to tell the app how many calories you want to consume, how many grams of protein, fat, and carbohydrates you want to consume (either each day, or day-to-day).

With each style you are give your estimated caloric burn and recommended caloric intake to achieve your goal.

Once a week, you’ll check-in with the app and it will adjust the plan based on calculated energy expenditure and weight.

## Energy expenditure 

The MacroFactor app uses your data to calculate this instead of data from wearables, general population, and so on. The proposition is that it’s personal and simplified.

There’s a well known calculation in the fitness and weight loss world’s:

```
calories in (consumption) - calories out (burn) = change in stored energy (weight)
```

Warning: algebra!

```
x - y = z

x = z + y

x - z = y
```

So...

```
calories in (consumption) - change in stored energy (weight) = calories out (burn)
```

You regularly track your consumption (food logging) and your weight, and MacroFactor can derive your energy output. It even displays the range.

Consistent and accurate tracking of weight and consumption does provide better results.

## Progress photos and body metrics

I haven’t fully explored this one beyond the ability to choose different body parts to measure the size of.

## Widgets

For iOS I don’t see a way to add a widget for MacroFactor to any of my screens.

## Shortcut bar

While not a marketable feature in the list, it’s possible to edit the shortcut menu to reduce the discrete actions required for things like weight, body measurements, recipes and so on.

[Read my personal reflections on the MacroFactor](/examinations/macrofactor-food-tracker/reflection/)

