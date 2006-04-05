<?xml version="1.0"?>
<!--

jira2sql.xsl:  A simple XSL stylesheet to convert JIRA's XML data into a series of SQL insert statement.  

Written 02/23/2006 by Anthony Atkins (anthony.atkins@vt.edu) for use with the requirements voting process.

-->

<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform"  version="1.0">
<xsl:output method="text" disable-output-escaping="yes"/>

<xsl:variable name="field_enclosure_character">'</xsl:variable>
<xsl:variable name="field_separation_character">,</xsl:variable>
<xsl:variable name="subfield_separation_character">|</xsl:variable>
<xsl:variable name="carriage_return"><xsl:text>
</xsl:text></xsl:variable>
<xsl:variable name="single_quote">'</xsl:variable>

<xsl:template match="/">
  <xsl:text>/* output from jira2sql.xsl */</xsl:text>
  <xsl:value-of select="$carriage_return"/>

  <xsl:apply-templates select="/rss/channel/item"/>
</xsl:template>

<xsl:template match="item">
  <xsl:text>insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values (</xsl:text>

  <xsl:apply-templates select="key"/>
  <xsl:value-of select="$field_separation_character"/>

  <xsl:value-of select="$field_enclosure_character"/>
  <xsl:value-of select="substring-after(key,'REQ-')"/>
  <xsl:value-of select="$field_enclosure_character"/>
  <xsl:value-of select="$field_separation_character"/>

  <xsl:apply-templates select="summary"/>
  <xsl:value-of select="$field_separation_character"/>

  <xsl:apply-templates select="description"/>
  <xsl:value-of select="$field_separation_character"/>

  <xsl:value-of select="$field_enclosure_character"/>
  <xsl:apply-templates select="customfields/customfield[customfieldname = 'Target Audience(s)']/customfieldvalues/customfieldvalue"/>
  <xsl:value-of select="$field_enclosure_character"/>
  <xsl:value-of select="$field_separation_character"/>

  <xsl:value-of select="$field_enclosure_character"/>
  <xsl:apply-templates select="component"/>
  <xsl:value-of select="$field_enclosure_character"/>

  <xsl:text>);</xsl:text>
  <xsl:value-of select="$carriage_return"/>
</xsl:template>

<xsl:template match="customfieldvalue">
  <xsl:if test="position() &gt; 1">
    <xsl:value-of select="$subfield_separation_character"/>
  </xsl:if>
  <xsl:call-template name="fix_quotes">
    <xsl:with-param name="input">
      <xsl:value-of select="."/>
    </xsl:with-param>
  </xsl:call-template>
</xsl:template>

<xsl:template match="component">
  <xsl:if test="position() &gt; 1">
    <xsl:value-of select="$subfield_separation_character"/>
  </xsl:if>
  <xsl:call-template name="fix_quotes">
    <xsl:with-param name="input">
  	<xsl:call-template name="Trim">
	   <xsl:with-param name="strInput" select="."/>
  	</xsl:call-template>
    </xsl:with-param>
  </xsl:call-template>
</xsl:template>

<xsl:template match="*">
  <xsl:value-of select="$field_enclosure_character"/>
  <xsl:call-template name="fix_quotes">
    <xsl:with-param name="input">
      <xsl:value-of select="."/>
    </xsl:with-param>
  </xsl:call-template>
  <xsl:value-of select="$field_enclosure_character"/>
</xsl:template>


<!-- simple recursive template to replace single quotes with double single quotes -->
<xsl:template name="fix_quotes">
  <xsl:param name="input"/>
  <xsl:choose>
    <xsl:when test="contains($input,$single_quote)">
      <xsl:value-of select="substring-before($input, $single_quote)"/>
      <xsl:value-of select="$single_quote"/>
      <xsl:value-of select="$single_quote"/>
      <xsl:call-template name="fix_quotes">
        <xsl:with-param name="input">
          <xsl:value-of select="substring-after($input, $single_quote)"/>
        </xsl:with-param>
      </xsl:call-template>
    </xsl:when>
    <xsl:otherwise>
      <xsl:value-of select="$input"/>
    </xsl:otherwise>
  </xsl:choose>
</xsl:template>

<!-- trim whitespace -->
<xsl:template name="Trim">
	<!--This template will recursively trim the trailing spaces from a string-->
   	<xsl:param name="strInput" select="''"/>
	<!-- Call the template that will trim off Left spaces (recursively, of course ) -->
	<xsl:variable name="InputL">
		<xsl:call-template name="TrimL" >
			<xsl:with-param name="strInput" select="$strInput"/>
		</xsl:call-template>
	</xsl:variable>

	<!-- Call the template that will trim off right spaces (recursively, of course ) -->
	<xsl:variable name="InputR">
		<xsl:call-template name="TrimR" >
			<xsl:with-param name="strInput" select="$InputL"/>
		</xsl:call-template>
	</xsl:variable>
	<xsl:value-of select="$InputR" />
</xsl:template>

<xsl:template name="TrimL">
	<!--This template will recursively trim the trailing spaces from a string-->
   	<xsl:param name="strInput" select="''"/>
	<xsl:variable name="strLen" select="string-length($strInput)" />
	<xsl:variable name="strOutput" select="substring($strInput, 2, $strLen - 1 )" />
	<xsl:variable name="strFirstChar" select="substring($strInput, 1, 1 )" />

	<xsl:choose> 
	   <xsl:when test="$strFirstChar = ' '">	
		<!-- At this point, the template will recursively call itself until it is trimmed -->
		<xsl:call-template name="TrimL" > 
			<xsl:with-param name="strInput" select="$strOutput"/>
		</xsl:call-template>
	   </xsl:when>
	   <xsl:otherwise>
		<xsl:value-of select="$strInput" />
	  </xsl:otherwise>
	</xsl:choose>
</xsl:template>

<xsl:template name="TrimR">
	<!--This template will recursively trim the trailing spaces from a string-->
   	<xsl:param name="strInput" select="''"/>
	<xsl:variable name="strLen" select="string-length($strInput)" />
	<xsl:variable name="strOutput" select="substring($strInput, 1, $strLen - 1 )" />
	<xsl:variable name="strLastChar" select="substring($strInput, $strLen, 1 )" />

	<xsl:choose> 
	   <xsl:when test="$strLastChar = ' '">	
		<!-- At this point, the template will recursively call itself until it is trimmed -->
		<xsl:call-template name="TrimR" > 
			<xsl:with-param name="strInput" select="$strOutput"/>
		</xsl:call-template>
	   </xsl:when>
	   <xsl:otherwise>
		<xsl:value-of select="$strInput" />
	   </xsl:otherwise>
	</xsl:choose>
</xsl:template>

</xsl:stylesheet>