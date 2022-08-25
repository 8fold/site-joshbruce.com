# Calculate portfolio matrix

{!! dateblock !!}

A portfolio matrix is used to tell us what percentage of value is or should be where. For example, the following could be used for a portfolio in general:

|Category |Percent |
|:--------|:-------|
|Cash     |6       |
|Low correlation |6 |
|Negative correlation |6 |
|Equities |82 |

When I was fist introduced to the term, it was mainly in relation to equities, using a 9 cell matrix, like the following (also called a “style box”):

| |Value |Blend |Growth |
|:-----|:--:|:--:|:--:|
|Large |x |x |x |
|Mid   |x |x |x |
|Small |x |x |x |

If we add all the percentages together, they should add up to 100 percent or darn close.

If you’re investing in individual companies, it will most likely be 100 percent in one cell of the matrix. With that said, it might move over time because the valuation and operations of the company may change. For example, in 2022 Meta Platforms (formerly Facebook) is set to move from growth to value, [according to Marketwatch](https://www.marketwatch.com/story/meta-platforms-poised-to-become-value-stock-in-russell-rebalancing-this-month-says-jefferies-11654565304). Further, Tesla started their life in the stock market as a small-cap company and are now a large-cap (Meta Platforms started as a large-cap).

While the style box could be used for individual stocks, I haven’t seen a tool that presents it that way; the closest I’ve seen is inputting an individual stock will say whether it’s small-, mid-, or large-cap. We’ll Use mutual funds for the rest of this article.

## Reference tables

Using the [Morningstar tool](https://www.morningstar.com/etfs/arcx/voo/portfolio), which popularized the matrix, we can start by creating what we’ll call the reference tables. These are tables that shouldn’t need updating very often.

We’ll look at the Vanguard S&P 500 index fund (VOO):

| |Value |Blend |Growth |
|:-----|:--:|:--:|:--:|
|Large |18 |31 |36 |
|Mid   |4 |9 |3 |
|Small |0 |0 |0 |

The index itself looks at the companies in the New York Stock Exchange ordered by market capitalization in descending order. So, roughly 85 percent of those companies are classified as large-cap and none are considered small-cap. Further, roughly 39 percent are considered growth. Finally, roughly 22 percent are considered value.

Now let’s look at an extended market fund (Vanguard’s VXF):

| |Value |Blend |Growth |
|:-----|:--:|:--:|:--:|
|Large |0 |0 |8 |
|Mid   |8 |16 |15 |
|Small |17 |24 |12 |

If we put these into a spreadsheet application, we can start doing calculations to create a matrix specific to our portfolio.

## Enter the matrix

The next step after creating the reference tables is to duplicate the reference tables and enter the percent that security occupies in the portfolio. Each cell in the matrix is the product of multiplying the same cell in the reference table by the percent the security occupies in the portfolio. We’ll use a list instead of the table to make it more internet-friendly.

Let’s use a total stock market fund (Vanguard’s VTI) and the extended market fund (Vanguard’s VXF).

VTI looks like this:

- Large-cap value: 15
- Large-cap blend: 26
- Large-cap growth: 31
- Mid-cap value: 5
- Mid-cap blend: 10
- Mid-cap growth: 5
- Small-cap value: 3
- Small-cap blend: 4
- Small-cap growth: 2

VXF looks like this:

- Large-cap value: 0
- Large-cap blend: 0
- Large-cap growth: 8
- Mid-cap value: 8
- Mid-cap blend: 16
- Mid-cap growth: 15
- Small-cap value: 17
- Small-cap blend: 24
- Small-cap growth: 12

Let’s set our allocation to be 34 percent VTI and 66 percent VXF. 

VTI looks like this (multiply each by 34 percent or 0.34):

- Large-cap value: 15 * 0.34 = 5.1
- Large-cap blend: 26 = 8.84
- Large-cap growth: 31 = 10.54
- Mid-cap value: 5 = 1.7
- Mid-cap blend: 10 = 3.4
- Mid-cap growth: 5 = 1.7
- Small-cap value: 3 = 1.02
- Small-cap blend: 4 = 1.36
- Small-cap growth: 2 = 0.68

VXF looks like this (multiply each by 66 percent or 0.66):

- Large-cap value: 0
- Large-cap blend: 0
- Large-cap growth: 8 * 0.66 = 5.28
- Mid-cap value: 8 = 5.28
- Mid-cap blend: 16 = 10.56
- Mid-cap growth: 15 = 9.9
- Small-cap value: 17 = 11.22
- Small-cap blend: 24 = 15.84
- Small-cap growth: 12 = 7.92

Now we create a new matrix combining the values from the other two, which represents our spread:

- Large-cap value: 5.1 + 0 = 5.1
- Large-cap blend: 8.84 + 0 = 8.84
- Large-cap growth: 10.54 + 5.28 = 15.88
- Mid-cap value: 1.7 + 5.28 = 6.98
- Mid-cap blend: 3.4 + 10.56 = 13.96
- Mid-cap growth: 1.7 + 9.9 = 11.6
- Small-cap value: 1.02 + 11.22 = 12.24
- Small-cap blend: 1.36 + 15.84 = 17
- Small-cap growth: 0.68 + 7.92 = 8.6

This is a way to play around with mixes to see what happens. Great for setting targets. For seeing where you are, look at the next section; because we’ve set that precedent apparently.

## Your current mix

Create another table breaking down the equities portion by adding a row for each security and enter the value. Add them all together, then divide each row by that total to get the current percent that security occupies in your portfolio.

Create tables like we did in the previous section and use this percent as the multiplier for each cell and you’ll have your current style.

I find this particularly helpful because in some cases you don’t get to choose the exact securities you want. For example, if I had my druthers, I wouldn’t be invested in the S&P 500 fund; however, being able to break it down like this I can figure out a way to tilt the portfolio and get close to my targets with that fund being included.