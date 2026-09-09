---
title: Network Protocols and Reconnaissance
date: 2026-09-08
category: networking
tags: [recon, networking, protocols, pentesting]
---

---

## Introduction

Reconnaissance is the foundation of every successful security assessment. Before vulnerabilities can be identified or exploited, a tester must first understand the target environment: what systems exist, what services are exposed, and how those systems communicate.

This information-gathering phase is often divided into two categories:

- **Passive Reconnaissance** — collecting intelligence without directly interacting with the target.
- **Active Reconnaissance** — sending traffic to the target to discover hosts, services, and network paths.

Both approaches are valuable. Passive techniques minimise detection and legal risk, while active techniques provide deeper visibility into the target's infrastructure.

Understanding the protocols that underpin these activities is equally important. Many common internet services were designed decades ago, often without security in mind. While modern replacements have improved security, legacy protocols remain widespread and continue to present opportunities for attackers and defenders alike.

This article explores both reconnaissance methodologies and the network protocols that make modern communication possible.

---

## Passive Reconnaissance

One of the most powerful and lowest-risk phases in penetration testing, bug bounties, and threat hunting, passive reconnaissance refers to gathering intelligence from public sources without making any direct contact with the target. Due to DNS, WHOIS, certificate logs, search engines, and device census platforms, there is a huge amount of useful data publicly available on the internet.

The primary advantage of passive reconnaissance is stealth. Because no packets are sent directly to the target, organisations typically have no visibility into the information-gathering process.

### WHOIS and RDAP

WHOIS is a query-and-response protocol that provides information about domain ownership and registration. Historically, WHOIS servers listened on TCP port 43 and returned registration details for domains.

Information commonly returned includes:

- Registrar information
- Registration and expiration dates
- Name servers
- Domain status codes
- Abuse contact details

In 2025, ICANN officially replaced WHOIS with the Registration Data Access Protocol (RDAP), which provides structured JSON responses over HTTPS and improved privacy controls.

Example:

```bash
whois example.com
```

### DNS Enumeration

DNS records remain publicly accessible and often reveal valuable information about an organisation's infrastructure.

Tools such as **dig** and **nslookup** can be used to retrieve:

- A records
- MX records
- TXT records
- CNAME records
- Name server information

Example:

```bash
dig @1.1.1.1 example.com TXT
```

DNS records frequently reveal email providers, cloud infrastructure, verification tokens, and additional services that may become targets later in an assessment.

### DNSDumpster

DNSDumpster aggregates publicly available DNS information and often reveals forgotten or unadvertised subdomains.

These subdomains may expose:

- Administrative portals
- Development environments
- APIs
- Legacy applications

Because DNSDumpster relies entirely on publicly available data, it remains a passive reconnaissance technique.

### Certificate Transparency Logs

Certificate Transparency (CT) logs are one of the most effective methods for discovering subdomains.

Whenever a Certificate Authority issues a TLS certificate, the certificate is recorded in a public log. Since certificates frequently contain Subject Alternative Names (SANs), these logs often reveal additional domains and subdomains associated with a target.

### Shodan

Shodan is often described as a search engine for internet-connected devices.

Instead of indexing websites, Shodan indexes service banners collected from exposed systems across the internet, including:

- Web servers
- Cameras
- Routers
- Industrial control systems
- IoT devices

It provides valuable intelligence without requiring direct interaction with the target organisation.

### Why Passive Reconnaissance Matters

Passive reconnaissance triggers no alerts, carries minimal legal risk when used within scope, and frequently uncovers forgotten services and misconfigurations that active testing may never discover.

---

## Active Reconnaissance

Active reconnaissance involves directly interacting with a target by sending packets, making connections, and probing services. Unlike passive methods, active reconnaissance leaves traces that can appear in logs, intrusion detection systems, web application firewalls, and monitoring platforms.

The objective is to gather accurate information while remaining as unobtrusive as possible.

### Web Browsers

The web browser is often the most overlooked reconnaissance tool.

Using built-in Developer Tools and extensions such as Wappalyzer, an analyst can identify:

- Web technologies
- Frameworks
- Server software
- JavaScript libraries
- Certificate information
- Response headers

Because browser traffic closely resembles legitimate user activity, it is often one of the least suspicious forms of active reconnaissance.

### Ping

Ping uses ICMP Echo Requests to determine whether a host is reachable.

In addition to availability, ping responses can provide clues about the operating system through TTL values:

- Linux commonly starts at 64
- Windows commonly starts at 128

A lack of response does not necessarily indicate a host is offline; firewalls frequently block ICMP traffic.

### Traceroute

Traceroute maps the network path between two systems by incrementally increasing the packet TTL.

This reveals:

- Intermediate routers
- Potential filtering points
- Network topology
- Sources of latency

Example:

```bash
traceroute -T TARGET_IP
traceroute -I TARGET_IP
```

Different executions may follow different network paths depending on routing decisions.

### Telnet

Although largely replaced by SSH, Telnet remains useful for banner grabbing and service identification.

Connecting to a TCP port often reveals:

- Service names
- Software versions
- Configuration details

Example:

```bash
telnet TARGET_IP 80
```

Followed by:

```http
GET / HTTP/1.1
Host: target
```

The server's response frequently reveals valuable information about the application stack.

### Netcat

Netcat is one of the most versatile networking tools available.

It can be used for:

- Banner grabbing
- Port probing
- File transfer
- Client/server communication
- Troubleshooting services

Example:

```bash
nc TARGET_IP PORT
```

Because of its flexibility, Netcat is often called the "Swiss Army knife of networking."

---

## Common Network Protocols

Reconnaissance ultimately leads to interacting with services, and those services rely on network protocols. Understanding how these protocols operate is fundamental to both security testing and defence.

### Telnet

Telnet provides remote command-line access over TCP port 23.

Its major weakness is that all traffic, including usernames and passwords, is transmitted in cleartext. Anyone capable of intercepting traffic can read the session contents.

### HTTP and HTTPS

HTTP transfers web content between clients and servers.

Like Telnet, traditional HTTP transmits data in cleartext. HTTPS solves this problem by encrypting communication using TLS. Modern browsers actively warn users when visiting unencrypted websites.

Common web servers include:

- Nginx
- Apache
- IIS

### FTP

FTP was designed to transfer files between systems and remains surprisingly common despite its age.

Security concerns include:

- Cleartext credentials
- Cleartext file transfers
- Anonymous login configurations

Modern alternatives include:

- SFTP
- FTPS
- SCP

However, finding FTP during a penetration test often warrants further investigation.

### SMTP

SMTP is responsible for sending email between systems.

Modern deployments commonly use:

| Port | Purpose                         |
| ---- | ------------------------------- |
| 25   | Server-to-server mail transfer  |
| 587  | Client submission with STARTTLS |
| 465  | SMTPS                           |

SMTP's design also enables email spoofing, making it one of the primary technologies leveraged in phishing campaigns.

### POP3

POP3 retrieves email by downloading messages from a mail server to a local device.

Advantages include:

- Offline access
- Reduced server storage requirements
- Local archiving

However, synchronisation across multiple devices is limited.

### IMAP

IMAP was developed to solve the synchronisation limitations of POP3.

Rather than downloading and removing messages, IMAP maintains a central mailbox on the server and synchronises changes across all connected devices.

Because modern users access email from multiple devices, IMAP has become the dominant retrieval protocol.

---

## Conclusion

Reconnaissance is often described as information gathering, but in practice it is much more than that. It is the process of transforming an unknown environment into a map of systems, services, users, and potential attack paths.

Passive reconnaissance provides stealth and breadth. Active reconnaissance provides validation and depth.

Together, they form the foundation of every penetration test, bug bounty engagement, and defensive investigation.

Likewise, understanding the protocols that underpin internet communication—HTTP, FTP, SMTP, POP3, IMAP, and others—allows security professionals to recognise weaknesses, identify misconfigurations, and better understand how modern systems communicate.

The better you understand the network, the better you understand the attack surface.
