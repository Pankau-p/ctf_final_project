---
title: Nmap — The Complete Reference
date: 2026-06-25
category: tools
tags: [nmap, recon, scanning]
---

## Introduction

Before you can exploit anything, you need to know what's there. Nmap — Network Mapper — is the industry standard tool for answering that question. It maps networks, identifies live hosts, discovers running services, detects operating systems, and with the right scripts, can even probe for vulnerabilities.

A full Nmap scan moves through nine stages:

1. Enumerate Targets
2. Discover Live Hosts
3. Reverse-DNS Lookup
4. Scan Ports
5. Detect Version
6. Detect OS
7. Traceroute
8. Scripts
9. Write Output

This blog covers all of them. Think of it as a reference you can come back to during an engagement.

---

## Subnetting Basics

Before scanning, it helps to understand what you're scanning.

A **network segment** is a group of computers connected over a shared medium — Ethernet or WiFi. In an IP network, a **subnetwork** is one or more network segments connected to the same router. The key distinction: network segments are physical, subnetworks are logical.

When performing active reconnaissance against a subnet, the protocol you use to discover hosts depends on where you are:

- **Same subnet** — Use ARP queries to discover live hosts by resolving MAC addresses. This operates at the link layer.
- **Different subnet** — Use ICMP, TCP, or UDP. These are transport-layer protocols and work across router boundaries. Useful when ICMP Echo is blocked.

---

## Stage 1 — Enumerating Targets

Nmap accepts targets in several formats:

```bash
nmap MACHINE_IP outrun-ctf.com google.com   # Scan multiple targets
nmap 10.11.12.15-20                          # Scan a range (6 hosts)
nmap MACHINE_IP/30                           # Scan a subnet (4 hosts)
nmap -iL list_of_targets.txt                 # Read targets from a file
```

To list targets without scanning them:

```bash
nmap -sL TARGETS      # Lists targets and attempts reverse-DNS resolution
nmap -sL -n TARGETS   # Lists targets, skips DNS resolution
```

`-sL` is useful for confirming your target scope before committing to a scan. The reverse-DNS resolution it performs passively can also surface useful hostnames.

---

## Stage 2 — Discovering Live Hosts

Nmap uses ping by default to identify live hosts before scanning ports. If you want host discovery only — no port scanning — use:

```bash
nmap -sn TARGETS
```

How Nmap discovers hosts depends on your privilege level and network position:

**Privileged user on a local network:**
Nmap uses ARP requests. To run an ARP-only scan:

```bash
nmap -PR -sn TARGETS
```

**Privileged user on a remote network:**
Nmap uses ICMP Echo requests, TCP ACK to port 80, TCP SYN to port 443, and ICMP timestamp requests. To use ICMP Echo specifically:

```bash
nmap -PE -sn TARGETS
```

Note: ICMP Echo is frequently blocked by firewalls and is not always reliable on its own.

**Unprivileged user on a remote network:**
Nmap falls back to a TCP 3-way handshake, sending SYN packets to ports 80 and 443.

### TCP SYN Ping

Sends a packet with the SYN flag set to a TCP port. An open port replies; a closed port responds with RST. Only useful for confirming a host is up, not for port state.

```bash
nmap -PS21,22,80 -sn TARGETS   # SYN ping to specific ports
```

Privileged users can send SYN packets without completing the 3-way handshake, even if the port is open.

### TCP ACK Ping

Sends a packet with the ACK flag set. Port 80 is used by default.

```bash
nmap -PA22,80,443 -sn TARGETS
```

### UDP Ping

UDP is connectionless, so no reply is expected from an open port. However, a closed UDP port will return an ICMP port unreachable packet — which tells you the host is up.

```bash
nmap -PU53,161,162 -sn TARGETS
```

### Host Discovery Summary

| Scan Type              | Example Command                             |
| ---------------------- | ------------------------------------------- |
| ARP Scan               | `sudo nmap -PR -sn 10.200.6.0/24`           |
| ICMP Echo Scan         | `sudo nmap -PE -sn 10.200.6.0/24`           |
| ICMP Timestamp Scan    | `sudo nmap -PP -sn 10.200.6.0/24`           |
| ICMP Address Mask Scan | `sudo nmap -PM -sn 10.200.6.0/24`           |
| SYN Ping Scan          | `sudo nmap -PS22,80,443 -sn 10.200.6.0/30`  |
| ACK Ping Scan          | `sudo nmap -PA22,80,443 -sn 10.200.6.0/30`  |
| UDP Ping Scan          | `sudo nmap -PU53,161,162 -sn 10.200.6.0/30` |

| Option | Purpose                           |
| ------ | --------------------------------- |
| `-sn`  | Host discovery only, no port scan |
| `-n`   | No DNS resolution                 |
| `-R`   | Reverse-DNS lookup for all hosts  |

---

## Stage 3 — Reverse-DNS Lookup

Reverse-DNS lookup resolves IP addresses back to hostnames. This can reveal system roles — `mail`, `dc01`, `vpn`, `dev` — and help you understand network structure before you've sent a single probe.

```bash
nmap -R TARGETS   # Force reverse-DNS lookup for all hosts
nmap -n TARGETS   # Disable DNS lookup entirely
```

Worth noting: reverse-DNS is not always accurate, and the additional DNS queries will slow your scan down.

---

## Stage 4 — Basic Port Scans

A port identifies a network service running on a host. HTTP binds to TCP port 80, HTTPS to 443, SSH to 22, and so on. No more than one service can listen on any given TCP or UDP port at a time.

Nmap classifies ports into six states:

| State            | Meaning                                                       |
| ---------------- | ------------------------------------------------------------- |
| Open             | A service is actively listening                               |
| Closed           | No service listening, but port is accessible (not firewalled) |
| Filtered         | Nmap cannot determine state — likely firewalled               |
| Unfiltered       | Accessible but state unknown — seen with ACK scans            |
| Open\|Filtered   | Cannot determine if open or filtered                          |
| Closed\|Filtered | Cannot determine if closed or filtered                        |

### TCP Flags

Nmap crafts packets by setting TCP flags. Understanding what each flag does is essential for understanding what each scan type is actually doing:

| Flag | Purpose                                         |
| ---- | ----------------------------------------------- |
| URG  | Urgent — process this data immediately          |
| ACK  | Acknowledgement — confirms receipt of a segment |
| PSH  | Push — pass data to the application immediately |
| RST  | Reset — tear down the connection                |
| SYN  | Synchronise — initiate a 3-way handshake        |
| FIN  | Finished — sender has no more data to send      |

_[Insert TCP header diagram here]_

### TCP Connect Scan

Completes the full 3-way handshake to confirm a port is open, then tears it down with RST/ACK. The most reliable scan type but also the most visible — connections are logged.

```bash
nmap -sT TARGET
```

### TCP SYN Scan

The default scan mode. Requires root privileges. Sends a SYN packet and tears down the connection after receiving a response — never completing the handshake. Less likely to be logged.

```bash
nmap -sS TARGET
```

### UDP Scan

UDP is connectionless, so there is no handshake. A service on an open UDP port may not respond at all. A closed UDP port returns an ICMP port unreachable error (type 3, code 3). Slower than TCP scans and can be combined with a TCP scan.

```bash
nmap -sU TARGET
```

### Fine-Tuning Your Scans

**Port selection:**

| Option           | Effect                         |
| ---------------- | ------------------------------ |
| `-p22,80,443`    | Scan specific ports            |
| `-p1-1023`       | Scan a range                   |
| `-p-`            | Scan all 65535 ports           |
| `-F`             | Scan top 100 most common ports |
| `--top-ports 10` | Scan top 10 most common ports  |

**Timing:**

| Template | Description                                                 |
| -------- | ----------------------------------------------------------- |
| `-T0`    | Paranoid — one port at a time, 5 minute wait between probes |
| `-T1`    | Sneaky — slow, used in real engagements to avoid detection  |
| `-T2`    | Polite                                                      |
| `-T3`    | Normal — Nmap default                                       |
| `-T4`    | Aggressive — commonly used in CTFs                          |
| `-T5`    | Insane — fast and loud                                      |

---

## Stage 4 (Advanced) — Advanced Port Scans

By setting TCP flags in unexpected combinations, Nmap can extract more information — or evade detection — in ways that basic scans cannot.

### Null Scan

No flags set. All bits are zero.

```bash
nmap -sN TARGET
```

No response from an open port (or a firewalled one). A closed port responds with RST. Lack of RST means open or filtered.

### FIN Scan

Sends a TCP FIN packet.

```bash
nmap -sF TARGET
```

Same logic as Null — no response means open or filtered, RST means closed.

### Xmas Scan

Sets FIN, PSH, and URG simultaneously. Named for the lit-up appearance of the flags.

```bash
nmap -sX TARGET
```

Same caveats as Null and FIN.

These three scans — Null, FIN, Xmas — are more effective against **stateless firewalls**, which only inspect whether the SYN flag is set to detect connection attempts. A packet without SYN can bypass them entirely.

### Maimon Scan

Named after Uriel Maimon, who documented it in 1996. Sets FIN and ACK bits. Most targets respond with RST — but certain BSD-derived systems drop the packet if the port is open, inadvertently revealing it.

```bash
nmap -sM TARGET
```

Rarely useful on modern networks.

### ACK Scan

Sends a TCP packet with the ACK flag set.

```bash
nmap -sA TARGET
```

The target responds with RST regardless of port state — because an ACK packet arriving without a prior connection makes no sense to the TCP stack. This scan does not reveal open ports in simple setups.

Its value is against firewalled targets. By observing which ACK packets get a RST response (unblocked) versus no response (blocked), you can map firewall rules and identify which ports are filtered.

### Window Scan

Almost identical to ACK scan, but examines the TCP Window field of the RST responses. On certain systems, a non-zero window value indicates the port is open.

```bash
nmap -sW TARGET
```

More useful when a firewall is in the picture.

### Custom Scan

Build your own flag combination:

```bash
nmap --scanflags RSTSYNFIN TARGET
```

Useful for experimentation and evading signature-based detection.

### Advanced Port Scan Summary

| Scan Type  | Command                                           | Notes                     |
| ---------- | ------------------------------------------------- | ------------------------- |
| TCP Null   | `sudo nmap -sN TARGET`                            | No flags set              |
| TCP FIN    | `sudo nmap -sF TARGET`                            | FIN flag only             |
| TCP Xmas   | `sudo nmap -sX TARGET`                            | FIN + PSH + URG           |
| TCP Maimon | `sudo nmap -sM TARGET`                            | FIN + ACK; BSD-specific   |
| TCP ACK    | `sudo nmap -sA TARGET`                            | Maps firewall rules       |
| TCP Window | `sudo nmap -sW TARGET`                            | Examines RST window field |
| Custom     | `sudo nmap --scanflags URGACKPSHRSTSYNFIN TARGET` | Define your own flags     |

---

## Evasion Techniques

### Spoofing

In some network configurations, you can scan using a spoofed IP or MAC address. Only reliable if you can capture the responses — otherwise the target's replies go to the spoofed address, not you.

```bash
nmap -e NET_INTERFACE -Pn -S SPOOFED_IP TARGET
```

MAC spoofing is only possible on the same Ethernet or WiFi network:

```bash
nmap --spoof-mac SPOOFED_MAC TARGET
```

### Decoys

Rather than spoofing entirely, decoys flood the target with scan traffic appearing to come from multiple IPs — hiding the real attacker's address in the noise.

```bash
nmap -D 10.10.0.1,10.10.0.2,ME TARGET          # Attacker appears as third source
nmap -D 10.10.0.1,10.10.0.2,RND,RND,ME TARGET  # Two random IPs added
```

### Fragmented Packets

Nmap can split packets into smaller fragments to bypass firewalls and IDS systems that fail to reassemble and inspect fragmented traffic.

```bash
nmap -f TARGET    # Fragment into 8-byte chunks
nmap -ff TARGET   # Fragment into 16-byte chunks
nmap --mtu NUM TARGET  # Custom MTU — must be a multiple of 8
```

_[Insert IP header diagram here]_

A **firewall** inspects at minimum the IP and transport layer headers, blocking or permitting traffic based on rules. A more sophisticated firewall also inspects transport layer data.

An **IDS** (Intrusion Detection System) goes further — it inspects packet data against known malicious patterns and raises alerts on matches.

Fragmentation can get past both when they lack the capability or configuration to reassemble and inspect fragmented streams.

### Idle / Zombie Scan

The most sophisticated evasion technique. Requires an idle host on the network — one generating no traffic of its own. Nmap makes scan probes appear to originate from the idle host by monitoring changes in its IP Identification (IP ID) field.

```bash
nmap -sI ZOMBIE_IP TARGET
```

**How it works — three steps:**

1. Send a SYN/ACK to the idle host to record its current IP ID value.
2. Send a spoofed SYN packet to the target, appearing to come from the idle host's IP.
3. Send another SYN/ACK to the idle host and compare the new IP ID to the one recorded in step 1.

**Interpreting the result:**

| IP ID Difference | Meaning                                                                                           |
| ---------------- | ------------------------------------------------------------------------------------------------- |
| +1               | Port is closed or filtered — target sent RST to idle host, which ignored it                       |
| +2               | Port is open — target sent SYN/ACK to idle host, which responded with RST, incrementing the IP ID |

The idle host must genuinely be idle. If it is generating its own traffic, the IP ID values will be meaningless.

---

## Output and Verbosity

```bash
nmap --reason TARGET   # Explains how Nmap reached each conclusion
nmap -v TARGET         # Verbose output
nmap -vv TARGET        # Very verbose
nmap -d TARGET         # Debugging output
nmap -dd TARGET        # More detailed debugging
```

| Option     | Purpose                                        |
| ---------- | ---------------------------------------------- |
| `--reason` | Shows why Nmap classified each port as it did  |
| `-v / -vv` | Progressively more verbose scan output         |
| `-d / -dd` | Debugging — useful when results are unexpected |

---

## Conclusion

Nmap is not just a port scanner — it is a structured reconnaissance workflow. Each stage builds on the last: you enumerate targets, confirm which are live, resolve hostnames, identify open ports, fingerprint services, detect operating systems, and optionally run scripts to go deeper. Understanding what Nmap is actually doing at each stage — which packets it sends, what responses it expects, and why — is what separates someone running commands from someone who understands the results.

The advanced scans and evasion techniques covered here matter beyond CTFs. Firewall mapping with ACK scans, idle scanning to obscure your origin, fragmentation to bypass IDS — these reflect how real engagements are conducted. The tool is the same. What changes is how deliberately you use it.

---

## Flags Quick Reference

| Option               | Purpose                               |
| -------------------- | ------------------------------------- |
| `-sT`                | TCP Connect scan                      |
| `-sS`                | TCP SYN scan (default, requires root) |
| `-sU`                | UDP scan                              |
| `-sN`                | Null scan                             |
| `-sF`                | FIN scan                              |
| `-sX`                | Xmas scan                             |
| `-sM`                | Maimon scan                           |
| `-sA`                | ACK scan                              |
| `-sW`                | Window scan                           |
| `-sI ZOMBIE_IP`      | Idle/Zombie scan                      |
| `-f / -ff`           | Fragment packets (8 / 16 bytes)       |
| `-S SPOOFED_IP`      | Spoof source IP                       |
| `--spoof-mac MAC`    | Spoof MAC address                     |
| `-D DECOY,ME`        | Decoy scan                            |
| `-p-`                | Scan all ports                        |
| `-F`                 | Fast scan (top 100 ports)             |
| `-T0` to `-T5`       | Timing templates                      |
| `--reason`           | Show reasoning                        |
| `-v / -vv`           | Verbose / very verbose                |
| `-d / -dd`           | Debug / more debug                    |
| `-sn`                | Host discovery only                   |
| `-PR`                | ARP ping                              |
| `-PE`                | ICMP Echo ping                        |
| `--source-port PORT` | Specify source port                   |
| `--data-length NUM`  | Append random data to packets         |
