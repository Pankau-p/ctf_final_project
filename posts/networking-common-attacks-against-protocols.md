---
title: Common Attacks Against Network Protocols
date: 2026-04-08
category: networking
tags: [sniffing, mitm, password-attacks, protocols, pentesting]
---

## Introduction

Servers running the protocols discussed above are subject to several categories of attack. The fundamental attack categories remain the same, but the techniques and tools used to exploit them have evolved.

- **Sniffing attacks** are harder on properly configured networks with widespread TLS adoption, but remain effective against misconfigured services, unencrypted internal networks, and legacy systems.
- **MITM attacks** are mitigated by technologies such as HSTS and certificate validation, but can still succeed when authentication or encryption is improperly implemented.
- **Password attacks** have evolved well beyond simple brute force. Attackers now commonly use credential stuffing, password spraying, and large collections of compromised credentials.
- **Protocol vulnerabilities** can expose systems to exploitation, but the actual impact depends on how the vulnerable service is configured, exposed, and used.

Understanding these attacks is important because an open port is only the beginning. The protocol running behind that port determines what information may be exposed, how authentication works, and what opportunities may exist for an attacker.

---

### Sniffing Attacks

A sniffing attack uses a network packet capture tool to intercept traffic between parties. When cleartext protocols are in use, all data — including credentials and private messages — is visible to anyone with access to the network path.

Sniffing remains a significant attack vector due to legacy systems, unencrypted internal corporate networks, misconfigured services, IoT devices, wireless networks, and post-MITM environments where encryption has been downgraded or stripped.

Sniffing can be conducted using an Ethernet (802.3) network interface with appropriate privileges.

Common tools include:

- **Tcpdump**
- **Wireshark**
- **Tshark**

---

### Man-in-the-Middle (MITM) Attacks

A Man-in-the-Middle attack occurs when a victim believes they are communicating with a legitimate destination but is unknowingly communicating through an attacker.

MITM attacks become significantly easier when the two parties do not properly verify the authenticity and integrity of communications.

#### Methods

- **ARP Spoofing** — The attacker sends forged ARP messages to associate their MAC address with the IP address of the default gateway or target. Traffic intended for those systems is redirected through the attacker. This is primarily effective on local networks.
- **DNS Spoofing** — Fake DNS responses redirect victims to attacker-controlled servers.
- **Rogue Access Points** — Fake wireless access points are deployed in public spaces. Victims connect to the malicious network and route traffic through the attacker.
- **BGP Hijacking** — An internet routing-level attack where an attacker announces false BGP routes to redirect traffic through their infrastructure. This is considerably more sophisticated than local-network attacks.

#### Tools

- **Bettercap** — ARP spoofing, DNS spoofing, HTTP/HTTPS proxying, and other network attacks.
- **Ettercap** — A network interception and analysis framework with similar capabilities.
- **mitmproxy** — An interactive proxy for inspecting and modifying HTTP traffic.
- **Responder** — A Windows-focused tool that abuses network name-resolution protocols.

MITM attacks can also involve downgrading HTTPS connections to HTTP, presenting fraudulent certificates, or exploiting compromised certificate authorities.

---

### Password Attacks

Most protocols require authentication — and as breach databases and security research have repeatedly demonstrated, many passwords are weak, reused, or already compromised.

Common attack types include:

- **Dictionary attacks** — Trying passwords from a predefined wordlist.
- **Brute force attacks** — Systematically trying possible password combinations.
- **Credential stuffing** — Using credentials leaked in previous breaches against other services.
- **Password spraying** — Trying a small number of common passwords against many accounts to avoid triggering account lockouts.
- **Hybrid attacks** — Combining dictionary-based guesses with systematic modifications or brute-force techniques.

Security researchers have compiled extensive wordlists from publicly available breach data. The appropriate wordlist depends heavily on the context and target.

**THC Hydra** is a fast, flexible, multi-protocol password attack tool.

Example:

```bash
hydra -l username -P wordlist.txt server service
```

Other commonly used tools include:

- **Hashcat**
- **John the Ripper**
- **Burp Suite Intruder**
- **Medusa**
- **Ncrack**

Each tool has different strengths depending on the authentication mechanism, protocol, and testing scenario.

---

## Conclusion

Network protocols define how systems communicate, but many of the protocols still encountered during security assessments were designed long before today's threat landscape existed.

Cleartext protocols such as Telnet and traditional HTTP can expose sensitive information to anyone able to observe the traffic. Weak authentication mechanisms can make services susceptible to password attacks, while poorly protected networks can allow attackers to intercept or manipulate communications through techniques such as ARP spoofing and DNS spoofing.

Modern security controls have addressed many of these weaknesses. TLS protects communications, secure authentication reduces credential exposure, and network segmentation limits the reach of an attacker. However, legacy protocols and poorly configured services continue to exist in real environments.

For a penetration tester, understanding these weaknesses turns protocol identification into something more useful than simply recording an open port. **The protocol tells you how the service communicates, what assumptions it makes about security, and what kinds of attacks may be possible.**

That is why protocol knowledge remains a fundamental part of understanding an attack surface.
