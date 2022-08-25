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

Using the [Morningstar tool](https://www.morningstar.com/etfs/arcx/voo/portfolio), which popularized the matrix, we’ll look at the Vanguard S&P 500 index fund (VOO):

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

Let’s say we have a portfolio and it’s 50–50 S&P 500 and extended market fund, we essentially create a new fund, with a different matrix. We multiply each cell by the percent it occupies in the total portfolio, in this case, 50 percent (0.5) and add the product of each cell together:

| |Value |Blend |Growth |
|:-----|:--:|:--:|:--:|
|Large |18 * 0.5 = 9 |31 * 0.5 = 15.5 |36 * 0.5 = 18 |
|Mid   |4 * 0.5 = 2 |9 * 0.5 = 4.5 |3 * 0.5 = 1.5 |
|Small |0 |0 |0 |

| |Value |Blend |Growth |
|:-----|:--:|:--:|:--:|
|Large |0 |0 |8 * 0.5 = 4 |
|Mid   |8 * 0.5 = 4 |16 * 0.5 = 8 |15 * 0.5 = 7.5 |
|Small |17 * 0.5 = 8.5 |24 * 0.5 = 12 |12 * 0.5 = 6 |

Which makes the style grid for this portfolio something like:

| |Value |Blend |Growth |
|:-----|:--:|:--:|:--:|
|Large |9 |15.5 |22 |
|Mid   |6 |12.5 |9 |
|Small |8.5 |12 | 6 |

