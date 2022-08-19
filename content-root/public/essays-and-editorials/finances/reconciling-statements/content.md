# Reconciling statements

{!! dateblock !!}

Reconciling statements is the act of comparing the information you have from your bookkeeping to the records of another source; usually the custodian of an account. A sanity check.

While the Investopedia article on [reconciliation](https://www.investopedia.com/terms/r/reconciliation.asp) is geared toward business, the same is true for any legal entity, including a person.

Two things are presumed when it comes to reconciliation:

1. The account is held somewhere other than in your head.
2. The somewhere else is keeping their own records on your activity within those accounts.

A general recommendation is that you do [double-entry bookkeeping](/essays-and-editorials/finances/#double-entry-bookkeeping).

As of this writing I use [Wave](https://www.waveapps.com) for my accounting and budgeting software. I appreciate the experience for double-entry bookkeeping and [reconciliation](https://support.waveapps.com/hc/en-us/articles/208621636-How-to-use-Account-Reconciliation). Receive statement, specify end date, put in balance as of that date, and usually that's it; unless something is off. 

Different accounts and institutions have different intervals for the generation of statements. These statements will typically show starting and ending balances for each account or security; there is no standard across institutions—so, each statement starts as an exercise in learning where the information is and what it's called. 

- The starting balance of one statement should match the ending balance of the previous statement.
- The running balance in your ledger should match the ending balance shown on the statement for the given date.

I'd say there are three levels of reconciliation.

1. Surface: Check the statement ending balance and your ledger balance on that date. If they match, you're probably okay; the caution here is that you may have duplicate entries you're not aware of that don't impact the ending balance.
2. Entry-for-entry: If the surface-level reconciliation doesn't work out, chances are transactions are missing, your ledger might have too many transactions, or, most often, the posting dates between your ledger and the statement might be causing the balances to be off.
3. Audit: This is when we feel like we need to do multiple reconciliations across multiple statements.

I recently did an audit of my accounts for 2021, which prompted me to write this. Mostly because reconciling investment statements has been pretty frustrating and inconsistent, but I think I have it sorted.

## Cash and credit card accounts

I find cash and credit card accounts to be much easier to reconcile than investments. With that said, not all loan accounts are the same. For some loan accounts you may have an entry for interest on the loan, or, you'll want to locate the principle balance as opposed to the amount owed, which will fluctuate like the value of investments.

I'm going to presume you use software or keep a ledger with a running balance.

Look at your statement. Most likely there is a place on the statement that starts with something like, "Starting" or "Prior" or "Previous" and ends with "as of" a date. There should also be a place on the statements that starts with something like, "Ending" or "New" or just "Balance." There might be other information that isn't going to help you when it comes to reconciliation.

The following is from a bank statement:

![Portion of a bank statement showing Beginning Balance of $0.01, End Balance of $0.01, and $0.01 for both deposits and withdrawals](/media/finances/bank-statement-balances.png)

The following is from a credit card statement:

![Portion of a credit card statement showing Previous Balance of $103.56, New Balance of $346.47, and a censored block for fees and other transaction types associated with the account](/media/finances/credit-card-statement-balances.png)

In your ledger, go to the entry with the same date as the statement starting date, or the entry just before that date. Look at the running balance; it should match. Now go to the entry with the same date as the statement ending date, or the entry just before that date; the running balance in your ledger should match the balance on the statement. 

## Investments

- Focus on total cost or total cost basis.
- Avoid looking at entries that have the word "sweep" in them; they are transitory transactions for settling purposes.
- Favor the transaction or trade date, not the settlement date for entries.

After many statements, phone calls, and false starts, I believe I've figured out a way to reconcile the statements I receive for investments. I've also decided to be a little more judgmental on institutions based on their statements and the ease with which I can reconcile the accounts.

Let's start with the accounting software for creating your ledger.

For each bucket of securities, I have an account in my chart of accounts. (Note: For M1 Finance, I only added the base Pie to my chart of accounts.) When I purchase more shares, I record money leaving one account and going to the settlement (or cash) account at the broker; negative entry from the first and positive entry to the second. Then I transfer the money from the settlement account to the account representing the security.

Because there doesn't seem to be standardization across the industry on statements for investment and retirement accounts, I'm going to break this up into three types of statements based on the style and information I've seen for each.

### Settlement account and total cost (basis)

These statements will typically list each security at the top for a summary view. The first security is often the settlement (or cash) account, which can be reconciled like cash accounts (see previous section). The other summary entries are usually separated by the security.

![Portion of a Vanguard statement showing the money market settlement account on the first line; with price on and balance on the statement end date as well as the balance for the same date the previous year. An entry for a single security is on the second line showing the name of the fund, the average price per share, total cost, quantity, price on and balance on the last date of the statement, as well as, the balance on the same date the previous year.](/media/finances/investment-statement.png)

What's nice here is that each security will list the total cost (basis), not the average or just the fair market value on a specific date. The total cost on the statement should match the running balance in your ledger on that date.

If it doesn't, you'll want to look for (and at) the individual entries to ensure you haven't missed anything. I typically do the bookkeeping for these accounts manually and sometimes don't add the dividend entries when they happen, for example.

Generally speaking, when looking at the individual entries, avoid entries that say things like "sweep in" or "sweep out," which basically means, "this money isn't really in an account yet" or "this money is in transit, but we're going to tell you about it anyway."

Total cost includes:

1. Every purchase of the security.
2. Dividends earned, whether reinvested or not; there will typically be two entries in the statement when dividends are reinvested, however, you may want to use a single entry for your bookkeeping. The first entry on the custodian's statement will be the dividends going into the [sweep account](https://investor.vanguard.com/investor-resources-education/online-trading/settlement-fund) before being put back into the security with a second transaction.
3. Realized gains. Note: Mutual funds may have realized gains despite you not selling any shares.
4. Realized losses. Note: Same as previous.
5. Any administration fees outside the expense ratio of the securities; 401k and similar retirement accounts—check your statements and with the custodian of the account.

All of these should appear as entries on the statement from the custodian and on your ledger.

Statements that have total cost should be able to reconcile without being even a penny off.

If your statements don't show total cost, chances are you have one of the other types of statements. Note: This is when I start questioning whether I want to continue using this broker for the account.


### Faux securities

This is pretty much focused on platforms like M1 Finance. These statements don't show total cost while showing a lot of other information that doesn't help in simple reconciliation of accounts; percent of portfolio, percent change, and so on. However, they essentially let you create your own mutual fund.

You pick multiple securities and place them into a holding bucket. Each security has a percent of that bucket they can occupy. When you contribute money, it's distributed in a way to make the bucket balanced based on the those percentages.

When you look at the bucket, it will tell you total cost and how much you are up or down. When you look at the statement it only shows the individual securities, without showing total cost.

The leg up these statements have over the next style of statement is you can at least look at the buckets, which one or more of them will be in your accounting software to validate against. The statement, however, is somewhat useless for reconciling purposes; I still download it each month to have for my records.

Sign in to the app. You should see a cash account, which can be reconciled like any cash account; even with the statement. Then look at each bucket you have in your bookkeeping tool of choice; I only have the primary bucket in the bookkeeping software.

The problem is there is no way I'm aware of to pull a total cost on a given date. Which makes these types of accounts and statements pretty much the same as the next section when it comes to reconciling. 

## No total cost, possibly no entries

To be fair, I've only seen these with employer-sponsored retirement plans. Basically, these types of statements are not useful for reconciling purposes.

I still download the statement, however, I reconcile against the individual entries listed on the custodian's website. It's pretty tedious and I've messed up with these statements and accounts more than any other.

With that said, I've contacted the custodians and requested they change the statements to make them easier to reconcile or asked them where to find the information I was looking for.
