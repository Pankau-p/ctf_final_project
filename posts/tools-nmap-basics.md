---
title: Nmap Basics
date: 2026-06-25
category: tools
tags: [nmap, recon]
---

## What is Nmap?

Nmap is a network scanner used to discover hosts and services on a network.

## Basic Usage

Scan a single host:

```bash
nmap 192.168.1.1
```

Scan for open ports:

```bash
nmap -p 1-65535 192.168.1.1
```

## What I learned

Always start with a basic scan before going deeper.
