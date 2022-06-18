---
title: July 1st, 2022 paycheck
created: 20220701
data:
- label: Debt
  min: 0
  low: 0
  optimum: 0.3
  high: 0.5
  max: 1
  value: 0.7
- label: Cash
  min: 3
  low: 4.5
  optimum: 6
  high: 7.5
  max: 9
  value: 8.1
- label: Low correlation
  min: 0
  low: 0
  optimum: 0.3
  high: 0.5
  max: 1
  value: 1
- label: Negative correlation
  min: 0
  low: 0
  optimum: 0.3
  high: 0.5
  max: 1
  value: 0.8
- label: US equities - small
  min: 25
  low: 29.7
  optimum: 31.6
  high: 33.5
  max: 38
  value: 31.3
- label: US equities - mid
  min: 25
  low: 29.7
  optimum: 31.6
  high: 33.5
  max: 38
  value: 27.7
- label: US equities - large
  min: 25
  low: 28.4
  optimum: 31
  high: 35.3
  max: 37
  value: 30
fi-experiments:
# label, current, previous, start
- [0.0, 34.72, 38.42, 47.71]
- [0.2, 32.09, 35.35, 43.83]
- [0.4, 32.33, 35.47, 43.74]
- [0.6, 32.88, 35.83, 43.54]
- [0.8, 34.12, 36.78, 43.36]
- [1.0, 38.01, 40.69, 46.87]
- [1.1, 37.89, 40.58, 46.76]
- [1.2, 37.86, 40.55, 46.73]
---

# July 1st, 2022 paycheck

{!! dateblock !!}

{!! data !!}

The extended market fund is down more than 30 percent from its 52 week high, so, not putting any money toward that at the moment. Instead, I put the bull toward the multi-factor fund and the remaining to the total market fund. Even at over 30 percent down, the allocation to small-cap equities is the greatest portion, so, this is a good chance to see if the multi-factor fund does what I think it will; this is due to rebalancing the 401k.

I’ve added some more numbers to the allocation mix; in part to facilitate a meter visualization but also to help guide purchasing. Frank Vasquez from [Risk Parity Radio](https://www.riskparityradio.com) mentioned a [Michael Kitces](https://www.kitces.com/blog/category/5-investments/) article (and research) that showed 20 percent, relative tolerance bands are pretty effective (believe [this the article](https://www.kitces.com/blog/best-opportunistic-rebalancing-frequency-time-horizons-vs-tolerance-band-thresholds/)).

Brief explanation: Say you want your portfolio to be 60 percent equities and 40 percent bonds. Further, you’ve decided on 20 percent, relative tolerance bands. This means relative to the target, for our example, you’d rebalance if the percent of equities increased to 72 percent or dropped below 48 percent; for the bonds it’d be when they hit 48 percent or 32 percent, respectively. The relative part is twofold. First, it’s relative to the target. Second, the target is relative to the portfolio; not a fixed dollar amount.

The minimum and maximum for the allocation listed above is set using a target (optimum) and a deviation percentage. The deviation I use is 20 percent from the target; at least for the equities (for the other macro-allocations I’ve just set a percentage). As long as the value of the thing is within those bounds, the portfolio is considered balanced. 

When I first started the portfolio was so heavily weighted that these wide minimum and maximum values gave me an achievable goal; get the allocation balanced in one year. With the recent volatility in the markets I’m starting to see how things shift with valuation and contributions. Further, the rationale of more volatile things being on tighter bands seems to make sense to me. So, I’m experimenting with inner bands.

I’m not sure how this will play out in practice yet; therefore, I’m not updating the [investment policy](/experiences/finances/investment-policy/) or [personal budget](/experiences/finances/personal-budget/) quite yet.

My thought at the moment is the inner bands will help guide the contributions, withdrawals, and acquisition of rebalancing tokens. Meanwhile, the outer bands will be for opportunistic rebalancing; if the portfolio is that out of balance, just rebalance immediately. However, it won’t be a strict rebalance where things are brought and sold in a way that the portfolio goes back to the targets; instead, getting to the inner bands will be good enough.

The result should be that the equities don’t require rebalancing much, if ever, and the contributions or withdrawals will be enough to keep that portion in line. I won’t speculate what will happen as the portfolio allocation shifts from the Mark 0 to something like the Mark 1.

## The plateau

## Surgery

The bills continue coming in and I’m not appreciating the healthcare industry at the moment.

I live in the United States, so, complaining about the healthcare shouldn’t be much of a surprise.

## FI experiments

Details are in the [January 15th, 2022 paycheck](https://joshbruce.com/finances/building-wealth-paycheck-to-paycheck/20220115/#fi-experiments).

The hypothesis is when the Mark 0.0 mix is down, it‘ll be down more than the others. Further, when the Mark 0.0 is up, the others will be up and not too far behind the Mark 0.0. We will track the change since the previous paycheck as well as the change since we started tracking January 2022.

{!! fi-experiments !!}

{!! next-previous !!}
