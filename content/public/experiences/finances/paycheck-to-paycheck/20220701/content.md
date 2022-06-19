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

The extended market fund is down more than 30 percent from its 52 week high, so, not putting any money toward that at the moment. Instead, I put as much as I could toward the multi-factor fund and the remaining to the total market fund. Due to rebalancing the 401k, small-cap equities represents the highest proportion of the portfolio, even with a decline of over 30 percent in the extended market fund.

## Adjusting tolerances

I look at my portfolio mainly from the macro-allocation level listed above. Each macro-allocation has a target, or optimum, percent it should be in the overall portfolio; as of this writing:

1. Debt should be 0 percent.
2. Cash should be 6.
3. Alternatives should be 0.
4. Negative correlation should be 0.
5. Small- and mid-cap equities should be 32.
6. Large-cap should be 31.

I’m in accumulation mode, therefore, the portfolio is as close as it can be to a109 percent equities portfolio. Each macro-allocation is then given a tolerance; a tolerable deviation from that target, which gives us the minimum and maximum for that asset class (listed above).

Debt and cash can’t go lower than 0 and can’t be avoided given the way I pay bills and track this sorta thing, so, I use a static number to set the tolerance bands; same with alternatives and negative correlation.

For equities, I use 20 percent from the target, which was the optimum percent, relative to a target, identified by an article on [rebalancing and tolerance bands](https://www.kitces.com/blog/best-opportunistic-rebalancing-frequency-time-horizons-vs-tolerance-band-thresholds/), which I believe I first heard referenced by [Risk Parity Radio](https://www.kitces.com/blog/best-opportunistic-rebalancing-frequency-time-horizons-vs-tolerance-band-thresholds/). 

The target is the guideline, and the tolerance bands are the [guardrails](/essays-and-editorials/guidelines-and-guardrails/).

I’m starting to play with the idea I of inner bands as well.

These inner bands are set above and below the target but not above and below the minimum and maximum. The more volatile something is, the narrower the bands; for example, small-cap stocks tend to fluctuate in value more than large-cap, therefore, the inner bands would be narrower for small-cap. The idea here is we want to sell when it’s up because it could down any moment and we want to buy when it’s down because it could shoot the moon at any moment; see Bitcoin in 2021.

Note: Having the bands be narrower. For the riskier assets is counter to the suggestion of Frank Vasquez in [episode 181 of Risk Parity Radio](https://podcasts.apple.com/us/podcast/risk-parity-radio/id1525099266?i=1000566576318) where he suggests having the bands wider on the more volatile assets. The wider approach would result in less rebalancing than the narrower approach, however, you’d have to be able to stomach deeper drawdowns.

Anyway, here’s how I plan on using these tolerance bands.

For the most part, I want to be riding close to the target and will be using deposits and withdrawals to do so. The inner bands will be used to acquire rebalancing tokens in accordance with [my personal investment policy](/experiences/finances/investment-policy/#rebalancing-the-portfolio). The outer bands will be used for out of cycle rebalancing.

The result should be that the equities don’t require rebalancing much, if ever, and the contributions or withdrawals will be enough to keep equities in line. I won’t speculate what will happen as the portfolio allocation shifts from the Mark 0 to something like the Mark 1 and I actually start introducing negative correlation and alternative assets.

## The plateau

## Surgery

The bills continue coming in and I’m not appreciating the healthcare industry at the moment.

I live in the United States, so, complaining about the healthcare shouldn’t be much of a surprise.

## FI experiments

Details are in the [January 15th, 2022 paycheck](https://joshbruce.com/finances/building-wealth-paycheck-to-paycheck/20220115/#fi-experiments).

The hypothesis is when the Mark 0.0 mix is down, it‘ll be down more than the others. Further, when the Mark 0.0 is up, the others will be up and not too far behind the Mark 0.0. We will track the change since the previous paycheck as well as the change since we started tracking January 2022.

{!! fi-experiments !!}

{!! next-previous !!}
