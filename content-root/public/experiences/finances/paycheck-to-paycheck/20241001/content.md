# October 1st, 2024 paycheck

{!! dateblock !!}

{!! data !!}

A few of the funds paid dividends along with some of my other accounts. This is probably a contributing factor the dip that happened today, which was roughy 1 percent for all the funds.

Dividends in the accounts means some of the short-term assets are in accounts I can’t sell from yet.

For the [.Individual Retirement Accounts](IRAs) I decided to keep buying, even if I can’t do the full buying strategy with the cash available. So, I’ll be putting in orders when the market closes today.

I’m roughly 10 [.United States Dollars](USD) under my 3-month burn rate. So, I’m taking that as a win. Of course, a non-trivial amount of that is due to the cash balance in the tax-advantaged accounts that I can’t consider liquid at this time.

I have 19 sell orders open in my taxable brokerage account. There would have to be a pretty big rally for all of them to execute anytime soon. They are set to expire between the end of October through the end of November. So, it appears the selling protocol is still working as expected.

My net worth is about 2 percent higher than when I left my previous employer.

## Spreadsheet changes 

I modified my spreadsheet to take advantage of a gap I was noticing. 

I don’t know how to explain it simply yet, so pardon the bumps.

The short version is: Sometimes there’s a gap between the target amount and the calculated totals from buying or selling. The gap is enough to buy or sell more shares. When buying, sometimes I wouldn’t be able to because the 15 percent bracket would say 0 shares, despite there being enough in the gap to buy at least 1 share. Further, when selling, I’d like to get as close to the target as I can.

Let’s say I want to withdraw 1,879 USD by selling something currently valued at 181 USD per share. Under the current setup we get something like this:

1. 939.50 USD (50 percent) would be from selling each share at 190.05 USD (5 percent above the previous day’s closing price), which is roughly 4 shares.
2. 657.65 USD (35 percent) would be from selling each share at 185.53 USD (2.5 percent above the previous day’s closing price), which is roughly 3 shares.
3. 281.85 USD (15 percent) from selling each share at 182.81 USD (1 percent above the previous day’s closing price), which is roughly 1 share.

When you multiply the proposed number of shares by the amount they’d be sold for, you get the following:

1. `190.06 * 4 = 760.24` 
2. `185.53 * 3 = 556.59`
3. `182.81 * 1 = 182.81` 

Add those together and we get:

```
760.24 + 556.59 + 182.81 = 1,499.64 
```

If we subtract that total from the target, we get:

```
1879 - 1,499.64 = 379.36
```

So, even if all the sell orders executed, not only would we not hit the target, but we’d be short almost 400 USD.

There is also another variation where 15 percent would be enough to sell a share at 1 percent above the previous day’s closing price despite not having enough based solely on 15 percent of the target.

Determining the number of shares to sell is calculated by taking the target, multiplying by the percent, dividing by the price per share for the limit order, and rounding the result down (floor).

So, for the first example in our list:

```
181 + 5% = 190.05
 
1,879 * 50% = 939.50

939.50 / 190.05 = 4.943

floor(4.943) = 4

4 * 190.05 = 760.2
```

If we round up (ceiling), instead of down we go over the target, which would be a problem:

```
ceil(4.943) = 5 

5 * 190.05 = 950.25 
```

That’s why we round down, not up. 

We want to avoid locking ourselves out of selling should rounding down on the 15 percent order be 0 when it could be 1 due to the gap remain should the 35 and 50 percent orders go through.

Therefore, I modified the calculation for the 15 percent order to consider the gap. It still prioritizes the 15 percent first, but there’s another consideration. In logic terms it’s something like this:

```
closing price (cp) = 181
target amount (ta) = 1,879

x = cp + 1%
y = ta * 15%
z = floor(y / x)

If z is greater than 0, that's how many shares we sell; otherwise:

a = cp + %5
b = ta * 50%
c = floor(a / b)
d = a * c

f = cp + 2.5%
g = ta * 35%
h = floor(f / g)
i = f * h

j = d + i
k = ta - j

m = floor(k / x)

If m is greater than 0, that's how many shares we sell; otherwise, we dont sell any.
```

I found this could leave me in a bing if I *really* needed cash but the funds aren’t fluctuating enough to execute some of the orders. This is how we wind up with almost 20 orders that haven’t sold yet. So, I split the 15 percent bracket into a 5 percent and a 10 percent.

The 5 percent is for 2 cents over the previous close, and the 10 percent stays as-is. It uses the gap that remains after adding the total for the 10, 35, and 50 percent orders. There’s a high probability the 5 percent will end up with 0 shares to sell; therefore, it won’t stop me from placing the other orders. Having said that, it does allow for an interesting possibility.

The interesting possibility is being able to sell more than 1 share at 2 cents over while the 10 percent is at 1 share. There’s a higher probability of a 2 cent increase in share price than a 1 percent increase, and if I need cash, I need cash.

To demonstrate and wind out the example:

1. `190.06 * 4 = 760.24` 
2. `185.53 * 3 = 556.59`
3. `182.81 * 1 = 182.81` 
4. `171.02 * 2 = 342.04` 

`1,879 - 760.24 - 556.59 - 182.82 - 343.04 = 36.31`

Compare that to the original:

`1,879 - 760.24 - 556.59 - 182.81 = 379.36`

Much closer to the target. Maximizes selling at a higher price. Allows for high probability of at least one order going through, which should reduce the probability of having a bunch of orders outstanding that eventually get cancelled.

So, we’ll see how this goes.

## Newsletter follow-up

I am going to move to a email newsletter for this series.

I’ll most likely start with some type of banner at the top of each page for folks to sign up.

If no one signs up, no worries, and I won’t be writing on this topic for an audience until someone does.

Even so, I still think this is the longest running, consistent series I’ve ever put together, and it’s been a worthwhile personal experience because of that.

Appreciate you for making the time to read them.

{!! next-previous !!}