-- ============================================================================
--  Seed Content : 27 Nakshatra study topics (category_id = 4)
--  File         : sql/seed_nakshatras.sql
--  Run AFTER     : sql/schema.sql  (also keep seed_topics.sql already loaded)
--    mysql -u root -p < sql/seed_nakshatras.sql
-- ============================================================================

USE vedic_astrology_learn;

INSERT INTO topics (id, category_id, slug, sanskrit_name, name_en, name_np, sort_order, is_published) VALUES
(53,4,'ashwini','Ashwini','Ashwini','अश्विनी नक्षत्र',1,1),
(54,4,'bharani','Bharani','Bharani','भरणी नक्षत्र',2,1),
(55,4,'krittika','Krittika','Krittika','कृत्तिका नक्षत्र',3,1),
(56,4,'rohini','Rohini','Rohini','रोहिणी नक्षत्र',4,1),
(57,4,'mrigashira','Mrigashira','Mrigashira','मृगशिरा नक्षत्र',5,1),
(58,4,'ardra','Ardra','Ardra','आर्द्रा नक्षत्र',6,1),
(59,4,'punarvasu','Punarvasu','Punarvasu','पुनर्वसु नक्षत्र',7,1),
(60,4,'pushya','Pushya','Pushya','पुष्य नक्षत्र',8,1),
(61,4,'ashlesha','Ashlesha','Ashlesha','अश्लेषा नक्षत्र',9,1),
(62,4,'magha','Magha','Magha','मघा नक्षत्र',10,1),
(63,4,'purva-phalguni','Purva Phalguni','Purva Phalguni','पूर्व फल्गुनी नक्षत्र',11,1),
(64,4,'uttara-phalguni','Uttara Phalguni','Uttara Phalguni','उत्तरा फल्गुनी नक्षत्र',12,1),
(65,4,'hasta','Hasta','Hasta','हस्त नक्षत्र',13,1),
(66,4,'chitra','Chitra','Chitra','चित्रा नक्षत्र',14,1),
(67,4,'swati','Swati','Swati','स्वाति नक्षत्र',15,1),
(68,4,'vishakha','Vishakha','Vishakha','विशाखा नक्षत्र',16,1),
(69,4,'anuradha','Anuradha','Anuradha','अनुराधा नक्षत्र',17,1),
(70,4,'jyeshta','Jyeshta','Jyeshta','ज्येष्ठा नक्षत्र',18,1),
(71,4,'moola','Moola','Moola','मूल नक्षत्र',19,1),
(72,4,'purvashada','Purvashada','Purvashada','पूर्वाषाढा नक्षत्र',20,1),
(73,4,'uttarashada','Uttarashada','Uttarashada','उत्तराषाढा नक्षत्र',21,1),
(74,4,'shravana','Shravana','Shravana','श्रवण नक्षत्र',22,1),
(75,4,'dhanishta','Dhanishta','Dhanishta','धनिष्ठा नक्षत्र',23,1),
(76,4,'shatabhisha','Shatabhisha','Shatabhisha','शतभिषा नक्षत्र',24,1),
(77,4,'purva-bhadrapada','Purva Bhadrapada','Purva Bhadrapada','पूर्व भाद्रपदा नक्षत्र',25,1),
(78,4,'uttara-bhadrapada','Uttara Bhadrapada','Uttara Bhadrapada','उत्तर भाद्रपदा नक्षत्र',26,1),
(79,4,'revati','Revati','Revati','रेवती नक्षत्र',27,1);

INSERT INTO topic_content (topic_id, summary_np, summary_en, characteristics, effects, classical_reference, sanskrit_term, sanskrit_meaning) VALUES
(53,'अश्विनी सत्ताउं नक्षत्रहरूमध्ये पहिलो हो र यो मेष राशिको ० डिग्रीदेखि १३ डिग्री २० सम्म फैलिएको छ। यसको स्वामी ग्रह केतु र देवता दिव्य जुडवा वैद्य अश्विनी कुमार हुन्। घोडाको सिर चिन्हले गति, ऊर्जा र तुरुन्तै सुरु गर्ने हिम्मतलाई जनाउँछ। यहाँ जन्मेका व्यक्ति छिटो हिँड्ने, बहुमुखी र स्वतन्त्र स्वभावका हुन्छन्। नयाँ कुरा सिक्ने र अरूलाई उपचार दिने प्रवृत्ति उनीहरूमा प्राकृतिक रूपमा पाइन्छ। केतुको प्रभावले भौतिक कुराभन्दा आध्यात्मिक जिज्ञासा बढी देखिन्छ। जीवनको सुरुवाती चरणमा धेरै उतारचढाव आउँदा पनि अन्ततः आफ्नो क्षेत्रमा स्थापित हुन्छन्। समग्रमा यो नक्षत्र उत्साह, सेवा र आत्मविश्वासको प्रतीक हो।','Ashwini is the first of the twenty seven nakshatras and it covers the opening thirteen degrees and twenty minutes of Aries. Ketu rules this star while the divine twin physicians called the Ashwini Kumaras serve as its deities. The horse head symbol points to speed, vitality and the urge to start things at once. People born here are usually quick, energetic and fond of their independence. A natural pull toward healing and service shapes most of their choices. The Ketu influence also turns their interest toward spiritual study more than material gain. Early life brings frequent changes, yet steady effort later carries them to success.',
'१. छिटो र निर्णायक काम गर्ने क्षमता
२. ऊर्जाले भरिएको तथा यात्राप्रति आकर्षण
३. प्राकृतिक रूपमा उपचार र सेवा गर्ने स्वभाव
४. स्वतन्त्र र नेतृत्वप्रिय मनोवृत्ति
५. एकै ठाउँमा बस्न नसक्ने चञ्चलता',
'१. करियर: चिकित्सा, खेलकुद, सेना र यातायात क्षेत्रमा विशेष सफलता
२. सम्बन्ध: छिटो मन पराउने तर दीर्घकालीन बन्धनमा ढिला गर्ने
३. स्वास्थ्य: सिरदर्द र नसासम्बन्धी थकान बढी हुन सक्छ
४. आर्थिक: आय छिटो आउँछ तर खर्च पनि उत्तिकै छिटो हुन्छ
५. शिक्षा: नयाँ विषय छिटो सिक्ने र अनुसन्धानमा रुचि',
'Vedanga Jyotisha','अश्विनी','अश्वको सिर (the horse head)'),
(54,'भरणी नक्षत्र मेष राशिको १३ डिग्री २० देखि २६ डिग्री ४० सम्म फैलिने दोस्रो नक्षत्र हो। यसको स्वामी ग्रह शुक्र र देवता यमराज हुन्। योनि चिन्हले जन्म, रूपान्तरण र जीवनभर भोगिने कर्मफलको ओरलो बोक्छ। यसमा जन्मेका व्यक्ति सिर्जनशील, महत्वाकांक्षी र संघर्ष सहन सक्ने हुन्छन्। शुक्रको कोमलताले उनीहरूलाई कला, संगीत र सौन्दर्यप्रति गहिरो लगाव दिन्छ। यमराजको प्रभावले न्याय, सत्य र कर्तव्यप्रति उनीहरूको दृष्टि कडा हुन्छ। कहिलेकाहीँ भावनाको चरममा पुगेर छिटो निर्णय लिने प्रवृत्ति पनि देखिन्छ। कष्टलाई आशीर्वादमा बदल्ने क्षमता यस नक्षत्रको मुख्य विशेषता हो।','Bharani is the second nakshatra and it spreads from thirteen degrees twenty minutes to twenty six degrees forty minutes of Aries. Venus is its ruling planet and Yama, the keeper of death and dharma, is its deity. The symbol of the womb points to birth, transformation and the karmic load carried through life. Natives of this star are creative, ambitious and able to endure long struggles. The gentle touch of Venus gives them a love of art, music and beauty. The influence of Yama makes them strict about justice, truth and duty. Their main gift is the power to turn hardship into a blessing.',
'१. कठिनाइ सहने र परिवर्तनलाई अवसर बनाउने शक्ति
२. रचनात्मक कला र संगीतप्रति लगाव
३. सत्य र न्यायप्रति कडा निष्ठा
४. दृढ इच्छाशक्ति तथा महत्वाकांक्षा
५. भावनाको चरममा पुगेर छिटो निर्णय लिने बानी',
'१. करियर: कला, मनोरञ्जन, नेतृत्व र प्रबन्धन क्षेत्रमा उच्च पद
२. सम्बन्ध: वफादार तर जिद्दी, जीवनसाथीसँग घनिष्टता आवश्यक
३. स्वास्थ्य: रक्त र जननाङ्गसम्बन्धी समस्या सावधानी चाहिने
४. आर्थिक: कलात्मक कामबाट आय, विलासितामा खर्च बढी
५. सामाजिक: न्याय र सेवाका काममा सम्मान प्राप्त हुन्छ',
'Vedanga Jyotisha','भरणी','भरण गर्ने र पालनपोषण गर्ने (to bear and to nourish)'),
(55,'कृत्तिका तेस्रो नक्षत्र हो जुन मेषको अन्तिम तिहाइ भाग र वृष राशिको पहिलो दस डिग्रीसम्म फैलिएको छ। यसको स्वामी ग्रह सूर्य र देवता अग्नि हुन्। छुरी वा ज्वाला जस्तो प्रतीकले यसलाई तीक्ष्ण, शुद्ध गर्ने र अग्निमय बनाउँछ। यहाँ जन्मेका व्यक्ति बौद्धिक रूपमा तीव्र, विश्लेषणात्मक र निर्णय लिन सक्षम हुन्छन्। सूर्यले दिने आत्मविश्वासका कारण उनीहरू समूहमा छिटै अगुवा बन्छन्। भित्र संवेदनशील भए पनि बाहिर कडा देखिने गर्छन् र प्रियजनलाई जोगाउने स्वभाव राख्छन्। कहिलेकाहीँ रिस र अधैर्यले बोली कठोर हुन सक्छ। शुद्धीकरण र परिवर्तन यस नक्षत्रको मूल सन्देश हो।','Krittika is the third nakshatra and it spans the final part of Aries together with the first ten degrees of Taurus. The Sun rules this star and Agni, the fire deity, presides over it. A blade or flame as the symbol marks it out as sharp, purifying and full of fire. People born here are quick in thought, analytical and firm in making decisions. The solar influence gives them the confidence to lead a group without waiting for others. They may look hard from outside while staying sensitive and protective toward dear ones. Anger and impatience can at times make their speech harsh, so the lesson of this star is purification through restraint.',
'१. तीव्र बुद्धि र कुशल तर्क
२. परिवर्तन र शुद्धीकरणमा विश्वास
३. आत्मविश्वासी नेतृत्व गुण
४. बाहिर कडा तर भित्र संवेदनशील
५. रिस र अधैर्यलाई सन्तुलन गर्ने आवश्यकता',
'१. करियर: शिक्षा, पुरोहित्य, इन्जिनियरिङ र प्राविधिक काममा सफलता
२. सम्बन्ध: प्रियजनप्रति वफादार, बोली कडा भएकाले बुझाइ आवश्यक
३. स्वास्थ्य: ज्वरो, आँखा र त्वचासम्बन्धी तापक्रम जन्य समस्या
४. आर्थिक: परिश्रमबाट धन आर्जन, चपलताले लगानीमा लाभ
५. शिक्षा: विज्ञान र गणित जस्ता विषयमा उत्कृष्टता',
'Vedanga Jyotisha','कृत्तिका','काट्ने शस्त्र वा ज्वाला (the cutter and the flame)'),
(56,'रोहिणी चौथो नक्षत्र हो र यो वृष राशिको १० देखि २३ डिग्री २० सम्म फैलिएको छ। यसको स्वामी ग्रह चन्द्र र अधिष्ठाता देवता प्रजापति वा ब्रह्मा हुन्। गोरुगाडा वा रथको प्रतीकले वृद्धि, उर्वरता र ऐश्वर्यलाई जनाउँछ। यसमा जन्मेका व्यक्ति सुन्दर, रचनात्मक र भावनात्मक हुन्छन्। मीठो बोली र हँसमुख अनुहारले उनीहरू सजिलै मानिसहरूको प्रिय बन्छन्। चन्द्रको प्रभावले परिवारप्रति समर्पण र कोमलता बढाउँछ भने सौन्दर्यप्रतिको चाहना शक्तिशाली हुन्छ। भित्र जिद्दी र महत्वाकांक्षी भए पनि बाहिर शान्त देखिने गर्छन्। धैर्य र मेहनतले उनीहरूलाई आर्थिक समृद्धिसम्म पुर्‍याउँछ।','Rohini is the fourth nakshatra and it spreads from ten degrees to twenty three degrees twenty minutes of Taurus. The Moon rules this star and Prajapati or Brahma is presiding deity. The symbol of a plough or a chariot shows growth, fertility and prosperity. People born here are attractive, creative and deeply emotional. Sweet speech and a pleasant face soon make them dear to others. The lunar influence strengthens their devotion to family while the love of beauty runs deep. Inside they can be stubborn and ambitious, yet outside they stay calm, and patience with hard work slowly carries them toward material prosperity.',
'१. आकर्षक रृप तथा मधुर वाणी
२. रचनात्मक र कलात्मक प्रतिभा
३. परिवारप्रति गहिरो समर्पण
४. धैर्यवान् तर भित्रबाट जिद्दी
५. सौन्दर्य र विलासिताप्रति प्राकृतिक झुकाव',
'१. करियर: कला, संगीत, फैशन, कृषि र व्यापारमा सफलता
२. सम्बन्ध: जीवनसाथीप्रति वफादार, भावनात्मक आवश्यकता बढी
३. स्वास्थ्य: छाला, हार्मोन र मनसम्बन्धी उतारचढाव
४. आर्थिक: जमिन र सम्पत्तिबाट लाभ, बचतमा स्थिरता
५. शिक्षा: कला र साहित्यमा विशेष रुचि र नाम कमाउने',
'Vedanga Jyotisha','रोहिणी','हल्का रातो रंग (the reddish one)'),
(57,'मृगशिरा पाँचौं नक्षत्र हो जुन वृष राशिको अन्तिम भाग र मिथुनको पहिलो छ डिग्री ४० सम्म विस्तारित छ। यसको स्वामी ग्रह मंगल र देवता सोम हुन्। हिरणको सिर चिन्हले जिज्ञासा, खोजी र कोमलतालाई जनाउँछ। यसैले यसलाई खोजीको तारा पनि भनिन्छ। मंगलको ऊर्जा र चन्द्रको कोमलताको मिश्रणले गर्दा यहाँ जन्मेका व्यक्ति गतिशील तर भावुक पनि हुन्छन्। उनीहरू सञ्चारमा कुशल, मीठो बोल्ने र अरूको भावना बुझ्ने हुन्छन्। धेरै कुरामा रुचि लिने भएकाले कहिलेकाहीँ एकै ठाउँमा टिक्न गाह्रो हुन्छ। यात्रा, लेखन र अनुसन्धानमा उनीहरूको भविष्य उज्यालो हुन्छ।','Mrigashira is the fifth nakshatra and it covers the last part of Taurus with the first six degrees forty minutes of Gemini. Mars rules this star and Soma, the moon deity, presides over it. The deer head symbol shows curiosity, search and gentleness, which is why the star is called the star of the seeker. A blend of martian energy and lunar softness makes the natives active yet emotional. They are skilled in speech, pleasant in conversation and quick to read the feelings of others. Interest in many fields at once can make it hard for them to stay in one place. Writing, research and travel usually open bright doors for them.',
'१. जिज्ञासु र खोजी प्रकृति
२. सञ्चार तथा कथा वाचनमा कुशलता
३. संवेदनशील र दयालु हृदय
४. ऊर्जावान् तर भावनात्मक रूपमा चञ्चल
५. नयाँ अनुभव र यात्राप्रति लगाव',
'१. करियर: पत्रकारिता, लेखन, शिक्षण र अनुसन्धानमा सफलता
२. सम्बन्ध: कोमल व्यवहारले साथी बनाउन सजिलो, छिटो रिस पनि आउँछ
३. स्वास्थ्य: मानसिक तनाव र निद्रासम्बन्धी समस्या हुन सक्छ
४. आर्थिक: आयका स्रोत विविध, तर बचत गर्न कठिनाइ
५. शिक्षा: भाषा, मनोविज्ञान र विज्ञानमा रुचि राम्रो',
'Vedanga Jyotisha','मृगशिरा','हिरणको सिर (the deer head)'),
(58,'आर्द्रा छैटौं नक्षत्र हो र यो मिथुन राशिको ६ डिग्री ४० देखि २० डिग्री सम्म फैलिएको छ। यसको स्वामी ग्रह राहु र देवता शिवको उग्र रूप रुद्र हुन्। आँसुको थोपा वा हीरा जस्तो चिन्हले दुःखपछिको शुद्धीकरण र नयाँ सुरुवातलाई बोक्छ। यहाँ जन्मेका व्यक्ति बुद्धिमान, विश्लेषणात्मक र जिज्ञासु हुन्छन्। राहुको प्रभावले उनीहरूको मन बारम्बार परिवर्तन र नयाँ विचारतर्फ लैजान्छ। भावनात्मक रूपमा तीव्र भएकाले मुड परिवर्तन पनि धेरै हुन्छ। कठिन परिस्थितिबाट बाहिर निस्कने बलियो क्षमता यस नक्षत्रको ठूलो शक्ति हो। अनुसन्धान, मनोविज्ञान र सञ्चार जस्ता क्षेत्रमा उनीहरू उल्लेखनीय सफलता कमाउँछन्।','Ardra is the sixth nakshatra and it runs from six degrees forty minutes to twenty degrees of Gemini. Rahu is the ruling planet here and Rudra, the fierce form of Shiva, is the deity. The symbol of a teardrop or a diamond speaks of purification and fresh beginnings that follow pain. People born under this star are intelligent, analytical and endlessly curious. The Rahu influence keeps pulling their mind toward change and new ideas while strong emotion brings frequent swings of mood and temperament. Their real power lies in the ability to rise again after a period of trouble. Research, psychology and media are fields where they usually shine.',
'१. गहिरो विश्लेषण र तीव्र जिज्ञासा
२. भावनात्मक तीव्रता र मुड परिवर्तन
३. कठिनाइपछि बलियो बन्ने क्षमता
४. रहस्य र नयाँ प्रविधिप्रति आकर्षण
५. करुणा र दयाको उच्च भावना',
'१. करियर: शोध, इन्जिनियरिङ, पत्रकारिता र कम्प्युटर क्षेत्रमा उत्कृष्टता
२. सम्बन्ध: छिटो जोडिने तर छिटै टुट्ने प्रवृत्ति सावधानी चाहिने
३. स्वास्थ्य: नसा, निद्रा र मानसिक दबाबको समस्या
४. आर्थिक: अनियमित आय, झुट्टो लगानीमा जोखिम
५. शिक्षा: विज्ञान र प्रविधिमा गहिरो अध्ययन राम्रो',
'Vedanga Jyotisha','आर्द्रा','ओसिलो वा नम (the moist one)'),
(59,'पुनर्वसु सातौं नक्षत्र हो जुन मिथुनको अन्तिम भाग र कर्कट राशिको ३ डिग्री २० सम्म फैलिएको छ। यसको स्वामी ग्रह बृहस्पति र देवता देवताहरूकी आमा अदिति हुन्। धनुष र तीर राख्ने थैलीको प्रतीकले पुनः प्राप्ति र नवीकरणलाई जनाउँछ। यहाँ जन्मेका व्यक्ति शान्त, दयालु र सन्तोषी स्वभावका हुन्छन्। बृहस्पतिकृपाले विद्या, धर्म र आध्यात्मिकताप्रति उनीहरूको झुकाव बलियो बनाउँछ। मिथुन र कर्कटको दुई प्रभावले गर्दा कहिलेकाहीँ उत्साही त कहिलेकाहीँ हतोत्साह देखिन्छ। असफलतापछि छिटै उठ्ने र अरूको हेरचाह गर्ने गुण उनीहरूमा स्वाभाविक हुन्छ। ज्ञानको खोजी र सरल जीवन यस नक्षत्रका जातकको पहिचान हो।','Punarvasu is the seventh nakshatra and it covers the last part of Gemini with the first three degrees twenty minutes of Cancer. Jupiter rules this star and Aditi, the mother of the gods, is its deity. The symbol of a quiver of arrows stands for return, renewal and getting back what was lost. Natives of this star are calm, kind and contented by nature. The grace of Jupiter draws them toward learning, religion and spiritual life. The double influence of Gemini and Cancer sometimes leaves them enthusiastic and sometimes low in spirit, yet they recover quickly from failure and care for the people around them. A search for knowledge and a simple life mark their personality.',
'१. शान्त, दयालु र सन्तोषी स्वभाव
२. विद्या तथा आध्यात्मिकताप्रति गहिरो रुचि
३. असफलतापछि छिटो उठ्ने लचिलोपन
४. अरूको हेरचाह गर्न रुचाउने सेवा भावना
५. दुई प्रकृतिको स्वभावले निर्णयमा ढिलाइ',
'१. करियर: शिक्षण, लेखन, धर्म र परामर्श क्षेत्रमा सम्मान
२. सम्बन्ध: परिवार र मित्रसँग गहिरो जोड, भावनामा निर्भरता
३. स्वास्थ्य: कान, पाचन र गर्दनसम्बन्धी समस्या
४. आर्थिक: क्रमिक रूपमा सम्पत्ति वृद्धि, यात्राबाट लाभ
५. शिक्षा: उच्च शिक्षा र दर्शनमा विशेष सफलता',
'Vedanga Jyotisha','पुनर्वसु','पुनः समृद्ध हुने (returning to prosperity)'),
(60,'पुष्य अष्टम नक्षत्र हो र यो कर्कट राशिको ३ डिग्री २० देखि १६ डिग्री ४० सम्म फैलिएको छ। यसको स्वामी ग्रह शनि र देवता ब्रह्मा हुन्। गाईको थुनको प्रतीकले पोषण, वृद्धि र समृद्धिलाई जनाउँछ, जसले गर्दा यसलाई सबैभन्दा शुभ नक्षत्र मानिन्छ। यहाँ जन्मेका व्यक्ति अनुशासनप्रिय, जिम्मेवार र समाजसेवी हुन्छन्। अरूलाई संरक्षण र हेरचाह गर्ने गुणले उनीहरूलाई परिवार र समाजमा प्रिय बनाउँछ। शनिको प्रभावले धैर्य र दीर्घकालीन लक्ष्य प्राप्त गर्ने शक्ति दिन्छ। विद्वान, धार्मिक र तर्कशील मनोवृत्तिले उनीहरू गुरु वा सल्लाहकार जस्तै भूमिकामा जम्मा हुन्छन्। कहिलेकाहीँ अत्यधिक सहनशीलताले गर्दा आफ्नो अवसर गुमाउन पनि सक्छन्।','Pushya is the eighth nakshatra and it spreads from three degrees twenty minutes to sixteen degrees forty minutes of Cancer. Saturn rules this star and Brahma, the creator, is its deity. The symbol of the udder of a cow points to nourishment, growth and abundance, which is why this is counted among the most auspicious stars. People born here are disciplined, responsible and devoted to social service. The gift of protecting and caring for others makes them dear to both family and society. The Saturn influence grants patience and the strength to reach long term goals. Being learned, religious and logical, they often act as teachers or advisers, though excessive tolerance at times makes them miss their own opportunities.',
'१. अनुशासनप्रिय र जिम्मेवार स्वभाव
२. अरूको संरक्षण र सेवा गर्ने प्रवृत्ति
३. दीर्घकालीन लक्ष्य प्राप्त गर्ने धैर्य
४. विद्या र आध्यात्मिकताप्रति स्वाभाविक झुकाव
५. कहिलेकाहीँ आफ्नो अवसर गुमाउने अतिसहनशीलता',
'१. करियर: शिक्षण, प्रशासन, सामाजिक सेवा र राजनीतिमा सफलता
२. सम्बन्ध: भरपर्दा र हेरचाह गर्ने जीवनसाथी, पारिवारिक एकता
३. स्वास्थ्य: पेट र छातीसम्बन्धी समस्या सावधानी चाहिने
४. आर्थिक: बचतमा अनुशासन, जग्गा र कृषिबाट लाभ
५. शिक्षा: ज्ञान सञ्चय र गुरुको आशीर्वादले उच्च पद',
'Vedanga Jyotisha','पुष्य','पोषण र वृद्धि दिने (nourishing and fostering)'),
(61,'अश्लेषा नवौं नक्षत्र हो र यो कर्कट राशिको १६ डिग्री ४० देखि ३० डिग्री सम्म फैलिएको छ। यसको स्वामी ग्रह बुध र देवता नाग देवता हुन्। कुण्डलिएको सर्पको प्रतीकले गोपनीयता, बुद्धि र गहिरो अवलोकनलाई जनाउँछ। यहाँ जन्मेका व्यक्ति तीक्ष्ण बुद्धिका र विश्लेषणात्मक हुन्छन्। बुधको प्रभावले उनीहरूको सञ्चार कला प्रभावशाली बन्छ। कुनै पनि कुराको जरा सम्म पुग्ने क्षमताले उनीहरूलाई अनुसन्धान र रणनीतिमा अग्रणी बनाउँछ। गोप्य कुरा सुरक्षित राख्न सक्ने भएकाले विश्वासपात्र सल्लाहकार बन्छन्। शंका, ईर्ष्या र अधिकारभाव उनीहरूको कमजोर पक्ष हुन सक्छ। मनोविज्ञान, कानुन र गुप्तचर सेवाजस्ता क्षेत्रमा उनीहरू उल्लेखनीय हुन्छन्।','Ashlesha is the ninth nakshatra and it covers sixteen degrees forty minutes to thirty degrees of Cancer. Mercury rules this star and the serpent deities are its presiding power. The symbol of a coiled serpent points to secrecy, intelligence and deep observation. People born here are sharp in thought and analytical by habit. The Mercury influence makes their mode of communication highly effective and the capacity to reach the root of any matter keeps them ahead in research and strategy. Because they can hold a confidence they often become trusted advisers, though suspicion, jealousy and a domineering streak can be their weak side. Psychology, law and intelligence work are fields where they stand out.',
'१. तीव्र बुद्धि र गहिरो अवलोकन शक्ति
२. प्रभावशाली सञ्चार र वाक्पटुता
३. गोप्य कुरा सुरक्षित राख्ने भरपर्दोपन
४. रणनीति र योजना बनाउने कुशलता
५. शंका र ईर्ष्यालाई नियन्त्रण गर्ने आवश्यकता',
'१. करियर: मनोविज्ञान, कानुन, अनुसन्धान र प्रशासनमा सफलता
२. सम्बन्ध: विश्वासपात्र तर खुल्दै नखुल्ने स्वभावले दूरी
३. स्वास्थ्य: नसा, निद्रा र मानसिक तनावसँग जोडिएको समस्या
४. आर्थिक: बुद्धिले कमाइ, गोप्य लगानी र व्यापारमा लाभ
५. शिक्षा: गुह्य विषय र भाषा अध्ययनमा विशेष निपुणता',
'Vedanga Jyotisha','अश्लेषा','सर्पले वेढेको वा संलग्न (the coiled serpent)'),
(62,'मघा दसौं नक्षत्र हो र यो सिंह राशिको ० देखि १३ डिग्री २० सम्म फैलिएको छ। यसको स्वामी ग्रह केतु र अधिष्ठाता देवता पितृगण हुन्। राज सिंहासनको प्रतीकले सम्मान, पद र परम्पराको ओरलो देखाउँछ। यसमा जन्मेका व्यक्ति प्रभावशाली, करिश्माई र राजसी स्वभावका हुन्छन्। कुल र पूर्वजहरूप्रति गहिरो सम्मान उनीहरूको पहिचान हो। केतुको प्रभावले जहाँ पनि आफ्नो प्रभाव जमाउने चाहना र आध्यात्मिक रुचि दुवै बलियो बनाउँछ। नेतृत्व क्षमताका कारण समाजमा उच्च स्थान पाउँछन्। अहंकार र जिद्दीपन उनीहरूको कमजोर पक्ष हुन सक्छ। नैतिकतापूर्वक काम गरेमा मात्र स्थायी सफलता र यश टिक्छ।','Magha is the tenth nakshatra and it spreads from zero to thirteen degrees twenty minutes of Leo. Ketu rules this star and the ancestors, known as the Pitris, preside over it. The royal throne as a symbol shows honour, position and respect for tradition. People born here carry a powerful, charming and regal presence, and deep reverence for family and ancestors defines their identity. The Ketu influence strengthens both the wish to leave a mark wherever they go and a natural interest in spiritual matters. Leadership ability often lifts them to a high place in society. Pride and stubbornness can however become their weak side, and lasting success and fame come only when they act with ethics.',
'१. प्रभावशाली र करिश्माई व्यक्तित्व
२. परम्परा तथा पूर्वजप्रति गहिरो सम्मान
३. जन्मजात नेतृत्व क्षमता
४. महत्वाकांक्षा र सामाजिक प्रतिष्ठाको चाहना
५. अहंकार र जिद्दीपनलाई सन्तुलन गर्ने आवश्यकता',
'१. करियर: प्रशासन, राजनीति, न्याय र उच्च प्रबन्धनमा सफलता
२. सम्बन्ध: परिवारप्रति वफादार, अहंकारले विवाद ल्याउन सक्छ
३. स्वास्थ्य: आँखा, हड्डी र हृदयसम्बन्धी सावधानी
४. आर्थिक: ठूलो सम्पत्ति र यशको योग, उदार खर्चीलोपन
५. शिक्षा: इतिहास, संस्कृति र धर्मशास्त्रमा रुचि',
'Vedanga Jyotisha','मघा','महान र शक्तिशाली (the mighty and great)'),
(63,'पूर्व फल्गुनी ग्यारौं नक्षत्र हो र यो सिंह राशिको १३ डिग्री २० देखि २६ डिग्री ४० सम्म फैलिएको छ। यसको स्वामी ग्रह शुक्र र देवता ऋषि भृगु हुन्। खाटको अगाडिका खुट्टा जस्तो प्रतीकले सुख, विश्राम र दाम्पत्य जीवनलाई जनाउँछ। यहाँ जन्मेका व्यक्ति आकर्षक, कलात्मक र प्रेमप्रिय हुन्छन्। शुक्रको कोमल प्रभावले संगीत, कला र सौन्दर्यप्रति उनीहरूको लगाव गहिरो बनाउँछ। जीवनसाथीसँगको सम्बन्ध र साझेदारी उनीहरूको जीवनमा विशेष भूमिका खेल्छ। आरामप्रिय र विलासितालाई मन पराउने बानीले गर्दा कहिलेकाहीँ आलस्य देखिन्छ। जिम्मेवार भएपछि रचनात्मक क्षेत्रमा उनीहरू उल्लेखनीय नाम कमाउँछन्।','Purva Phalguni is the eleventh nakshatra and it covers thirteen degrees twenty minutes to twenty six degrees forty minutes of Leo. Venus rules this star and the sage Bhrigu is its deity. The front legs of a bed as a symbol speak of rest, comfort and married life. People born here are attractive, artistic and fond of love and pleasure. The gentle influence of Venus draws them deeply toward music, art and beauty. Relationship with life partner and partnerships play an important role in their life. A taste for comfort and luxury can at times breed laziness, but with responsibility they make a notable name in creative fields.',
'१. आकर्षक व्यक्तित्व र कलात्मक प्रतिभा
२. प्रेम र सुखप्रति प्राकृतिक झुकाव
३. दाम्पत्य जीवन र साझेदारीको महत्त्व
४. संगीत र सौन्दर्यमा विशेष रुचि
५. आरामप्रियता र आलस्यको सावधानी',
'१. करियर: कला, संगीत, फिल्म, डिजाइन र व्यापारमा सफलता
२. सम्बन्ध: जीवनसाथीप्रति गहिरो माया, साझेदारीमा लाभ
३. स्वास्थ्य: मिठासजन्य रोग र जननाङ्गसम्बन्धी समस्या
४. आर्थिक: सुखसुविधामा खर्च बढी, बचतमा अनुशासन चाहिने
५. शिक्षा: कला र मानवशास्त्रमा रुचि र उत्कृष्टता',
'Vedanga Jyotisha','पूर्व फल्गुनी','पहिलो फल्गुनी (the earlier pair of legs)'),
(64,'उत्तरा फल्गुनी बाह्रौं नक्षत्र हो जुन सिंहको अन्तिम भाग र कन्या राशिको १० डिग्रीसम्म फैलिएको छ। यसको स्वामी ग्रह सूर्य र देवता आर्यमा हुन्। खाटको पछाडिको खुट्टाको प्रतीकले विश्राम, सम्झौता र वैवाहिक जीवनलाई सूचित गर्छ। यहाँ जन्मेका व्यक्ति कर्तव्यपरायण, उदार र सम्मानप्रिय हुन्छन्। सूर्यको प्रभावले उनीहरूमा आत्मविश्वास र नेतृत्वको भाव बलियो हुन्छ। समाजमा विश्वासयोग्य र सभ्य व्यक्तिको रूपमा चिनिन्छन्। अनुशासन र योजनाबद्धताले गर्दा उनीहरूको दीर्घकालीन काम सफल हुन्छ। कहिलेकाहीँ गर्व र नियममा अत्यधिक जोड दिने बानी अवरोध बन्न सक्छ।','Uttara Phalguni is the twelfth nakshatra and it spans the final part of Leo with the first ten degrees of Virgo. The Sun rules this star and Aryaman, lord of contracts and hospitality, is its deity. The back legs of a bed as a symbol point to rest, agreements and married life. People born here are dutiful, generous and respectful by nature. The solar influence gives them strong confidence and a natural sense of leadership. Society sees them as trustworthy and well mannered persons, and discipline with planning usually makes their long term work succeed. Pride and over attachment to rules can sometimes become obstacles.',
'१. कर्तव्यपरायण र अनुशासित स्वभाव
२. उदार र सभ्य व्यवहार
३. आत्मविश्वासपूर्ण नेतृत्व योग्यता
४. सम्झौता र साझेदारीमा विशेष भाग्य
५. गर्व र कडा नियमबाट बच्ने आवश्यकता',
'१. करियर: प्रशासन, बैंकिङ, वकालत र व्यापारमा स्थिर सफलता
२. सम्बन्ध: जीवनसाथीसँग दीर्घकालीन सुखमय सम्बन्ध
३. स्वास्थ्य: आँखा, हड्डी र पाठीसम्बन्धी थकान
४. आर्थिक: नियमित आय र बचत, सम्पत्तिमा क्रमिक वृद्धि
५. शिक्षा: कानुन र प्रबन्धन जस्ता विषयमा उत्कृष्टता',
'Vedanga Jyotisha','उत्तरा फल्गुनी','पछिल्लो फल्गुनी (the latter pair of legs)'),
(65,'हस्त तेस्रौं नक्षत्र हो र यो कन्या राशिको १० देखि २३ डिग्री २० सम्म फैलिएको छ। यसको स्वामी ग्रह चन्द्र र देवता सविता हुन्। खुला हात वा हत्केलाको प्रतीकले काम, कुशलता र सिर्जनालाई जनाउँछ। यहाँ जन्मेका व्यक्ति हातमा सामान्यतया निपुण, चतुर र हँसमुख हुन्छन्। चन्द्रको कोमलताले उनीहरूलाई अरूको भावना बुझ्न र हेरचाह गर्न सक्षम बनाउँछ। कुनै पनि काम सिक्न छिटो लाग्ने गुणले उनीहरूलाई बहुक्षेत्रीय बनाउँछ। चञ्चल बुद्धिले एकै ठाउँमा लामो समय बस्न गाह्रो बनाउँछ। उपचार, शिल्प र हस्तकलामा उनीहरूको सफलता विशेष रूपमा उल्लेखनीय हुन्छ।','Hasta is the thirteenth nakshatra and it spreads from ten degrees to twenty three degrees twenty minutes of Virgo. The Moon rules this star and Savitr is its deity. An open hand or palm as a symbol shows work, skill and creation. People born here are usually skilful with their hands, clever and cheerful. The lunar softness lets them read the feelings of others and care for them well. A quick mind helps them learn any new task with speed, which makes them multi skilled, though that same restless mind can make it hard to stay in one place for long. They are especially noted for success in healing, craft and handwork.',
'१. हातमा उत्कृष्ट कुशलता र निपुणता
२. छिटो सिक्ने बहुमुखी बुद्धि
३. अरूको भावना बुझ्ने करुणा
४. हँसमुख र शीतल व्यवहार
५. चञ्चलताले एकै काममा जम्मा हुन गाह्रो',
'१. करियर: शिल्प, उपचार, शिक्षण र सेवा क्षेत्रमा सफलता
२. सम्बन्ध: मधुर व्यवहारले मित्रता फराकिलो, छिटै क्षमा गर्ने
३. स्वास्थ्य: हात, कलाइ र पाचनसम्बन्धी समस्या
४. आर्थिक: परिश्रमबाट सानो तर नियमित आय
५. शिक्षा: व्यावहारिक ज्ञान र हस्तकलामा विशेष दक्षता',
'Vedanga Jyotisha','हस्त','हातको हत्केला (the open hand)'),
(66,'चित्रा चौधौं नक्षत्र हो जुन कन्याको अन्तिम भाग र तुला राशिको ६ डिग्री ४० सम्म फैलिएको छ। यसको स्वामी ग्रह मंगल र देवता त्वष्टा वा विश्वकर्मा हुन्। चम्किलो रत्न वा मकर चिन्हले सुन्दर निर्माण र प्रतिभालाई जनाउँछ। यहाँ जन्मेका व्यक्ति आकर्षक शारीरिक रूप र रचनात्मक मन राख्छन्। मंगलको ऊर्जाले उनीहरूलाई परियोजना पूरा गर्ने तीव्र गति दिन्छ। वास्तुकला, डिजाइन र शिल्प जस्ता क्षेत्रमा उनीहरूको स्वाभाविक क्षमता देखिन्छ। बाहिर सधैँ सजिलो देखिने भए पनि भित्र परिश्रमी हुन्छन्। अलंकारप्रिय स्वभावले गर्दा खर्चिलोपन पनि हुन सक्छ। सुन्दर र टिकाउ कुरा बनाउने यस नक्षत्रको मूल पहिचान हो।','Chitra is the fourteenth nakshatra and it covers the last part of Virgo with the first six degrees forty minutes of Libra. Mars rules this star and Tvashtr, the divine architect, is its deity. A bright jewel or a pearl as a symbol shows beautiful construction and talent. People born here possess an attractive body and a creative mind. Mars gives them the speed to finish projects without delay. A natural gift for architecture, design and craft can be seen in them, and they may look easy going from outside while working hard within. A love of adornment can sometimes make them spend too much, yet their core identity is the power to build things that are both beautiful and lasting.',
'१. रचनात्मक र वास्तुकलामा प्रतिभा
२. आकर्षक शारीरिक उपस्थिति
३. परियोजना छिटो पूरा गर्ने ऊर्जा
४. सुन्दर र टिकाउ कुराप्रतिको झुकाव
५. खर्चिलोपन र देखावटप्रति अत्यधिक लगाव',
'१. करियर: वास्तुकला, डिजाइन, इन्जिनियरिङ र कलामा सफलता
२. सम्बन्ध: आकर्षणले जोडिने तर स्वतन्त्रताप्रति चाहना
३. स्वास्थ्य: मुखाको चोट, आगो जस्तो ताप र रक्तसम्बन्धी समस्या
४. आर्थिक: कलात्मक कामबाट आय, आभूषणमा बढी खर्च
५. शिक्षा: गणित, कला र प्राविधिक विषयमा रुचि',
'Vedanga Jyotisha','चित्रा','चम्किलो रत्न (the brilliant jewel)'),
(67,'स्वाति पन्ध्रौं नक्षत्र हो र यो तुला राशिको ६ डिग्री ४० देखि २० डिग्री सम्म फैलिएको छ। यसको स्वामी ग्रह राहु र देवता वायु देवता हुन्। हावामा डोलिरहेको नवागोरुको अंकुरको प्रतीकले स्वतन्त्रता, लचिलोपन र यात्रालाई जनाउँछ। यहाँ जन्मेका व्यक्ति स्वतन्त्र विचारका र भरपर्दा स्वभावका हुन्छन्। राहुको प्रभावले उनीहरूमा अनपेक्षित परिवर्तन र नयाँ प्रविधिप्रति आकर्षण देखिन्छ। सन्तुलन र व्यवहारिकताले गर्दा व्यापार र कूटनीतिमा उनीहरू सफल हुन्छन्। वायु जस्तै चञ्चल भए पनि आफ्नो लक्ष्यतर्फ सधैँ अगाडि बढ्छन्। विदेश, मीडिया र व्यापार उनीहरूको सफलताका मुख्य क्षेत्र हुन्।','Swati is the fifteenth nakshatra and it spreads from six degrees forty minutes to twenty degrees of Libra. Rahu rules this star and Vayu, the wind god, is its deity. A young shoot bending in the wind as a symbol shows freedom, flexibility and travel. People born here hold independent views and a reliable nature. The Rahu influence brings sudden changes in their life and a strong pull toward new technology. A sense of balance and practicality makes them succeed in trade and diplomacy, and like the wind they keep moving toward their goal. Foreign lands, media and commerce are the main fields of their success.',
'१. स्वतन्त्र र उदार विचार
२. परिवर्तन र नयाँ प्रविधिमा तत्परता
३. व्यापार र कूटनीतिमा सन्तुलित बुद्धि
४. यात्राप्रति प्राकृतिक लगाव
५. चञ्चलताले एकै काममा टिक्न गाह्रो',
'१. करियर: व्यापार, मीडिया, प्रविधि र अन्तर्राष्ट्रिय काममा सफलता
२. सम्बन्ध: स्वतन्त्रतालाई मूल्य दिने, विश्वास जित्ने क्षमता
३. स्वास्थ्य: छाला, एलर्जी र श्वासप्रश्वास सम्बन्धी समस्या
४. आर्थिक: विविध स्रोतबाट आय, आयातनिर्यातमा लाभ
५. शिक्षा: प्रविधि र अर्थशास्त्रमा नयाँ प्रयोग राम्रो',
'Vedanga Jyotisha','स्वाति','स्वतन्त्र र फर्कने (the independent one)'),
(68,'विशाखा सोह्रौं नक्षत्र हो जुन तुलाको अन्तिम भाग र वृश्चिक राशिको ३ डिग्री २० सम्म फैलिएको छ। यसको स्वामी ग्रह बृहस्पति र देवता इन्द्राग्नि हुन्। तोरणद्वार वा विकसित पाताको प्रतीकले लक्ष्यप्राप्ति र विस्तारलाई जनाउँछ। यहाँ जन्मेका व्यक्ति महत्वाकांक्षी, लक्ष्यस्थिर र परिश्रमी हुन्छन्। बृहस्पतिको प्रभावले उनीहरूमा ज्ञान, विश्वास र उदार व्यवहारलाई बलियो बनाउँछ। दुई राशिको मिश्रणले गर्दा उनीहरू एकै समयमा शान्त र तीव्र दुवै देखिन सक्छन्। जुन काम सुरु गरे पूरा गर्ने जिद्दी प्रवृत्तिले उनीहरूलाई नेतृत्वमा पुर्‍याउँछ। बहुमुखी बुद्धिका कारण व्यापार र अभियान्तिका दुवैमा सन्तुलन कायम गर्न सक्छन्। क्रोध र अधीरतालाई सम्हार्दै अगाडि बढ्दा सफलता दिगो हुन्छ।','Vishakha is the sixteenth nakshatra and it covers the final part of Libra with the first three degrees twenty minutes of Scorpio. Jupiter rules this star and Indra Agni is its deity. A gateway arch or a blossoming leaf as a symbol speaks of achievement and expansion. People born here are ambitious, steady in goal and hard working. The Jupiter influence strengthens their learning, faith and generous behaviour, and the mixture of two signs can make them appear calm and intense at the same time. A stubborn streak to finish whatever they begin often lifts them to leadership. Because their mind works on many fronts they can balance both trade and spiritual pursuits, and success becomes durable once they keep anger and haste under control.',
'१. लक्ष्यप्रति स्थिरता र परिश्रम
२. ज्ञान र विश्वासमा गहिराइ
३. नेतृत्वमा जाने प्राकृतिक क्षमता
४. व्यापार र अभियान्तिका दुवैमा बहुमुखी बुद्धि
५. क्रोध र अधीरतालाई नियन्त्रण गर्ने जरुरी',
'१. करियर: व्यापार, प्रबन्धन, धर्म र समाजसेवामा उच्च पद
२. सम्बन्ध: सहयोगी जीवनसाथी, अपेक्षा बढी राख्ने प्रवृत्ति
३. स्वास्थ्य: मधुमेह, यकृत र मिर्गौलासम्बन्धी सावधानी
४. आर्थिक: ठूलो योजनाबाट लाभ, उदार खर्च
५. शिक्षा: धर्मशास्त्र, व्यवस्थापन र कानुनमा सफलता',
'Vedanga Jyotisha','विशाखा','विस्तृत शाखा (the forked branch)'),
(69,'अनुराधा सत्रौं नक्षत्र हो र यो वृश्चिक राशिको ३ डिग्री २० देखि १६ डिग्री ४० सम्म फैलिएको छ। यसको स्वामी ग्रह शनि र देवता मित्र देवता हुन्। कमलको फूल चिन्हले शुद्धता, भक्ति र कठिनाइबाट उभिने शक्तिलाई जनाउँछ। यहाँ जन्मेका व्यक्ति विश्वासयोग्य, मेहनती र सङ्गठनशील हुन्छन्। शनिको अनुशासनले उनीहरूलाई दीर्घकालीन लक्ष्य प्राप्त गर्न सहयोग गर्छ। मित्रता र समूहमा काम गर्ने गुणले गर्दा व्यापार र समाजसङ्घमा उनीहरू प्रिय बन्छन्। विदेश र दूरको कामसँग जोडिएर सफलता पाउने प्रवृत्ति यस नक्षत्रमा देखिन्छ। स्वास्थ्य र शरीरको हेरचाहमा सावधानी आवश्यक हुन्छ। भक्ति, सेवा र धैर्य यस नक्षत्रले दिने तीन प्रमुख गुण हुन्।','Anuradha is the seventeenth nakshatra and it spreads from three degrees twenty minutes to sixteen degrees forty minutes of Scorpio. Saturn rules this star and Mitra, the god of friendship, is its deity. A lotus flower as the symbol shows purity, devotion and the power to rise through hardship. People born here are trustworthy, hard working and organised. The Saturn discipline helps them reach goals that take a long time, and a talent for group work makes them dear in social organisations. Success often comes through work linked with foreign lands or distant places. Care of health and body needs regular attention, while devotion, service and patience are the three chief gifts of this star.',
'१. विश्वासयोग्य र मेहनती व्यवहार
२. सङ्गठन र नेतृत्वमा कुशलता
३. दीर्घकालीन लक्ष्य प्राप्त गर्ने धैर्य
४. मित्रता र सामूहिक काममा निपुणता
५. भक्ति र सेवाप्रति स्वाभाविक झुकाव',
'१. करियर: प्रबन्धन, सेना, व्यापार र समाजसंगठनमा सफलता
२. सम्बन्ध: छिटो विश्वास गर्ने, दूरका सम्बन्धमा भाग्य
३. स्वास्थ्य: मुटु, हड्डी र मृदु अङ्गहरूको कमजोरी
४. आर्थिक: विदेश र दीर्घकालीन लगानीबाट स्थिर लाभ
५. शिक्षा: व्यवस्थापन र अन्तर्राष्ट्रिय सम्बन्धमा रुचि',
'Vedanga Jyotisha','अनुराधा','अनुकूल आराधना (devoted and well regarded)'),
(70,'ज्येष्ठा अठारौं नक्षत्र हो र यो वृश्चिक राशिको १६ डिग्री ४० देखि ३० डिग्री सम्म फैलिएको छ। यसको स्वामी ग्रह बुध र देवता इन्द्र हुन्। झुम्का वा सुरक्षाको छाताको प्रतीकले सम्मान, अधिकार र वरिष्ठतालाई जनाउँछ। यहाँ जन्मेका व्यक्ति बुद्धिमान, परिपक्व र जिम्मेवार हुन्छन्। बुधको प्रभावले तर्क, वाकपटुता र सञ्चारमा उनीहरू निपुण हुन्छन्। समूहमा नेतृत्व गर्ने क्षमताले उनीहरूलाई वरिष्ठ पदमा पुर्‍याउँछ। भित्र गोपनीयता र शंका राख्ने प्रवृत्ति पनि देखिन्छ भने अहंकारले बोली कठोर हुन सक्छ। शत्रुप्रति सावधान र आफ्नो कुनामा बलियो हुनु यस नक्षत्रको विशेषता हो। अधिकार र ज्ञानको सही प्रयोगले मात्र दीर्घ सम्मान दिलाउँछ।','Jyeshta is the eighteenth nakshatra and it covers sixteen degrees forty minutes to thirty degrees of Scorpio. Mercury rules this star and Indra, the king of the gods, is its deity. A jewelled earring or an umbrella as a symbol speaks of honour, authority and seniority. People born here are wise, mature and responsible, and the Mercury influence makes them skilled in logic, speech and communication. A natural ability to lead a group often places them in senior positions. A tendency to keep secrets and to doubt can develop within while pride may harden their speech, so staying alert toward rivals and strong in their own ground is typical of this star. Honour lasts long only when knowledge and authority are used rightly.',
'१. परिपक्व र जिम्मेवार मनोवृत्ति
२. नेतृत्व र वरिष्ठ पदप्रति प्राकृतिक योग्यता
३. तर्क र सञ्चारमा निपुणता
४. गोपनीयता र आत्मरक्षाको चेतना
५. अहंकार र शंकालाई सन्तुलन गर्ने जरुरी',
'१. करियर: प्रशासन, पत्रकारिता, कानुन र अनुसन्धानमा सफलता
२. सम्बन्ध: प्रियजनप्रति गोप्य भावना, विश्वास जित्न कठिन
३. स्वास्थ्य: जननाङ्ग, मुटु र तनावजन्य रोग
४. आर्थिक: आयातनिर्यात र अनुसन्धानबाट लाभ
५. शिक्षा: पुरातत्व, इतिहास र भाषामा गहिरो रुचि',
'Vedanga Jyotisha','ज्येष्ठा','श्रेष्ठ र वरिष्ठ (the eldest and the chief)'),
(71,'मूल उन्नीसौं नक्षत्र हो र यो धनु राशिको ० देखि १३ डिग्री २० सम्म फैलिएको छ। यसको स्वामी ग्रह केतु र देवता निरृति हुन्। जडको गुच्छा वा मूल सुँघारको प्रतीकले आधार, विनाश र पुनर्जन्मलाई जनाउँछ। यहाँ जन्मेका व्यक्ति तीव्र, साहसी र क्रान्तिकारी स्वभावका हुन्छन्। केतुको प्रभावले जडमा पुग्ने बुद्धि र आध्यात्मिक जागरणको चाहना दुवै बलियो बनाउँछ। कुनै पनि कुरा छोडेर एकदमै नयाँ बाटो लिने क्षमता उनीहरूमा प्राकृतिक हुन्छ। गुस्सा र भावनाको तीव्रता उनीहरूको कमजोर पक्ष हुन सक्छ। चिकित्सा, अनुसन्धान र आध्यात्मिक साधनामा उनीहरू उल्लेखनीय सफलता पाउँछन्। रूपान्तरण यस नक्षत्रको सबैभन्दा ठूलो सन्देश हो।','Moola is the nineteenth nakshatra and it spreads from zero to thirteen degrees twenty minutes of Sagittarius. Ketu rules this star and Nirriti, goddess of dissolution, is its deity. A bundle of roots as the symbol shows foundation, destruction and rebirth. People born here are intense, courageous and radical in outlook. The Ketu influence sharpens the mind that digs into the root of matters and deepens the longing for spiritual awakening. The ability to drop everything and take a completely new path comes naturally to them, though anger and emotional intensity can become their weak side. They earn notable success in medicine, research and spiritual practice, and transformation is the greatest message of this star.',
'१. जरासम्म पुग्ने तीव्र बुद्धि
२. साहस र क्रान्तिकारी परिवर्तनको शक्ति
३. आध्यात्मिक जागरणप्रति प्राकृतिक झुकाव
४. कुनै पनि कुरा छोड्ने निर्णायक प्रवृत्ति
५. गुस्सा र भावनाको तीव्रता नियन्त्रण गर्ने जरुरी',
'१. करियर: चिकित्सा, अनुसन्धान, धर्म र क्रान्तिकारी काममा सफलता
२. सम्बन्ध: गहिरो जोड तर छिटै ठूट्ने उतारचढाव
३. स्वास्थ्य: शरीरको जरा वा जडप्रभावित रोग सावधानी
४. आर्थिक: आकस्मिक उतारचढाव, जोखिममा ठूलो परिवर्तन
५. शिक्षा: गुह्य विज्ञान, खगोल र मनोविज्ञानमा रुचि',
'Vedanga Jyotisha','मूल','जरा वा मूल (the root)'),
(72,'पूर्वाषाढा बीसौं नक्षत्र हो र यो धनु राशिको १३ डिग्री २० देखि २६ डिग्री ४० सम्म फैलिएको छ। यसको स्वामी ग्रह शुक्र र देवता जलदेवता अपः हुन्। पानीको झरना वा हात्तीको दाँतको प्रतीकले विजय, तृप्ति र विस्तारलाई जनाउँछ। यहाँ जन्मेका व्यक्ति कलात्मक, अनुशासित र मितव्ययी हुन्छन्। शुक्रको प्रभावले उनीहरूको सोच व्यवस्थित र दूरदर्शी बन्छ। जल तत्वले गर्दा भावनात्मक गहिराइ र करुणा यस नक्षत्रका जातकमा पाइन्छ। ज्येष्ठ र कनिष्ठ दुवै सँग मिलेर काम गर्ने गुणले पारिवारिक व्यवसायमा सफलता दिलाउँछ। कहिलेकाहीँ आफ्नो मत लागू गर्न चाहने जिद्दीपन देखिन्छ। साहित्य, शिक्षा र आध्यात्मिक क्षेत्रमा उनीहरूको यश टिक्छ।','Purvashada is the twentieth nakshatra and it covers thirteen degrees twenty minutes to twenty six degrees forty minutes of Sagittarius. Venus rules this star and Apas, the water deity, is its presiding power. A fountain or the tusk of an elephant as a symbol shows victory, satisfaction and expansion. People born here are artistic, disciplined and careful with resources. The Venus influence makes their thinking methodical and far sighted, and the water element lends emotional depth and compassion to the natives. A knack for working with both elders and juniors brings success in family business. At times a stubborn wish to impose their own view can appear, yet their fame lasts in literature, teaching and spiritual fields.',
'१. कलात्मक र व्यवस्थित सोच
२. दूरदर्शी निर्णय लिने क्षमता
३. भावनात्मक गहिराइ र करुणा
४. सबैसँग मिलेर काम गर्ने गुण
५. आफ्नो मत लागू गर्ने जिद्दीपन',
'१. करियर: साहित्य, शिक्षण, धर्म र कलामा सफलता
२. सम्बन्ध: परिवार र समाजमा सम्मान, जीवनसाथीसँग गहिराइ
३. स्वास्थ्य: जरा वा नाभि क्षेत्रसम्बन्धी समस्या
४. आर्थिक: मितव्ययीताले सम्पत्ति सुरक्षित, कलाबाट आय
५. शिक्षा: जलसँग सम्बन्धित अध्ययन र अनुसन्धानमा रुचि',
'Vedanga Jyotisha','पूर्वाषाढा','पहिलो विजय (the earlier victory)'),
(73,'उत्तराषाढा एक्काइसौं नक्षत्र हो जुन धनुको अन्तिम भाग र मकर राशिको १० डिग्रीसम्म फैलिएको छ। यसको स्वामी ग्रह सूर्य र देवता विश्वेदेव हुन्। हात्तीको दाँत वा चारपाइको खुट्टाको प्रतीकले विजय, स्थिरता र शक्तिलाई जनाउँछ। यहाँ जन्मेका व्यक्ति दृढ, न्यायप्रिय र कठोर परिश्रमी हुन्छन्। सूर्यको प्रभावले उनीहरूमा आत्मविश्वास र अगुवाको गुण स्वाभाविक रूपमा हुन्छ। दुई राशिको दायरामा रहेकाले उनीहरू शिक्षा र सेवा दुवैलाई सन्तुलन गर्न सक्छन्। सामाजिक सेवा र न्यायका काममा उनीहरूको यश टिक्छ। परिवार र समाजमा ठूलो सम्मान पाउँदै जीवनको उत्तरार्धमा स्थिरता आउँछ। अत्यधिक आत्मविश्वासले कहिलेकाहीँ अरूको राय अनसुना हुने समस्या ल्याउँछ।','Uttarashada is the twenty first nakshatra and it spans the last part of Sagittarius with the first ten degrees of Capricorn. The Sun rules this star and the Vishvedevas, the universal gods, are its deities. The tusk of an elephant or the four legs of a bed as a symbol show victory, stability and strength. People born here are firm, just and hard working by nature. The solar influence gives them confidence and a natural gift for taking the lead. Standing in the span of two signs they can balance both learning and service, and their name lasts in social service and in the work of justice. Respect from family and society grows in later years, though excessive confidence at times makes them ignore the advice of others.',
'१. दृढ इच्छाशक्ति र कठोर परिश्रम
२. न्याय र समाजसेवाप्रति समर्पण
३. आत्मविश्वासपूर्ण नेतृत्व क्षमता
४. शिक्षा र सेवालाई सन्तुलन गर्ने योग्यता
५. अरूको राय अनसुना गर्ने प्रवृत्ति',
'१. करियर: सरकारी सेवा, शिक्षण, न्याय र सामाजिक संस्थामा प्रतिष्ठा
२. सम्बन्ध: परिवारप्रति जिम्मेवार, साथीहरूमा विश्वासको आधार
३. स्वास्थ्य: हड्डी, मुटु र दाँतसम्बन्धी समस्या
४. आर्थिक: परिश्रमबाट क्रमिक सम्पत्धि वृद्धि
५. शिक्षा: उच्च शिक्षा र अनुसन्धानमा स्थिर सफलता',
'Vedanga Jyotisha','उत्तराषाढा','पछिल्लो विजय (the later victory)'),
(74,'श्रवण बाइसौं नक्षत्र हो र यो मकर राशिको १० देखि २३ डिग्री २० सम्म फैलिएको छ। यसको स्वामी ग्रह चन्द्र र देवता विष्णु हुन्। कान वा तीन पैरको छापको प्रतीकले सुन्ने, सिक्ने र मार्गदर्शन पाउने शक्तिलाई जनाउँछ। यहाँ जन्मेका व्यक्ति उत्तम श्रोता, धैर्यवान् र ज्ञानप्रिय हुन्छन्। चन्द्रको प्रभावले उनीहरूको मन कोमल र संवेदनशील बन्छ। गुरु र विद्वानसँग जोडिने उनीहरूको स्वाभाविक प्रवृत्ति हो। परिवार र समाजप्रति उनीहरूको कर्तव्यबोध बलियो हुन्छ। अरूको कुरा डाँट्नुभन्दा सुन्ने गुणले गर्दा उनीहरू विश्वासयोग्य मित्र बन्छन्। इतिहास, भाषा र धर्मशास्त्र जस्ता विषयमा उनीहरूको उत्कृष्टता विशेष हुन्छ।','Shravana is the twenty second nakshatra and it spreads from ten degrees to twenty three degrees twenty minutes of Capricorn. The Moon rules this star and Vishnu is its deity. An ear or three footprints as a symbol show the power to listen, to learn and to receive guidance. People born here are excellent listeners, patient and fond of knowledge. The lunar influence keeps their mind soft and sensitive. A natural tendency to stay close to teachers and learned persons marks them, and their sense of duty toward family and society stays strong. The habit of listening rather than scolding makes them trusted friends, and they show special skill in history, language and religious study.',
'१. उत्तम श्रोता र धैर्यवान् स्वभाव
२. ज्ञान र अध्ययनप्रति गहिरो लगाव
३. परिवार र समाजप्रति बलियो कर्तव्यबोध
४. कोमल मन र संवेदनशीलता
५. भावनामा बहकर निर्णय लिने जोखिम',
'१. करियर: शिक्षण, सूचना, पत्रकारिता र अनुसन्धानमा सफलता
२. सम्बन्ध: भरपर्दा मित्र र सुन्ने जीवनसाथी, पारिवारिक एकता
३. स्वास्थ्य: कान, मधुमेह र तल्लो अङ्गसम्बन्धी समस्या
४. आर्थिक: अनुशासित बचत, सम्पत्धि र नाम दुवै आर्जन
५. शिक्षा: भाषा, इतिहास र धर्मशास्त्रमा विशेष निपुणता',
'Vedanga Jyotisha','श्रवण','सुन्ने र श्रवण गर्ने (the ear that hears)'),
(75,'धनिष्ठा तेइसौं नक्षत्र हो जुन मकरको अन्तिम भाग र कुम्भ राशिको ६ डिग्री ४० सम्म फैलिएको छ। यसको स्वामी ग्रह मंगल र देवता अष्ट वसु हुन्। ढोल वा बाँसुरीको प्रतीकले संगीत, समूह र धनको ओरलो देखाउँछ। यहाँ जन्मेका व्यक्ति ऊर्जावान्, निर्णायक र समूहमा अगुवा बन्न सक्षम हुन्छन्। मंगलको प्रभावले उनीहरूमा साहस र प्रतिस्पर्धा भाव बलियो हुन्छ। संगीत र कलाप्रति प्राकृतिक लगाव रहेकाले सार्वजनिक क्षेत्रमा नाम कमाउँछन्। समूहमा सिद्धान्त र आर्थिक कुरामा सधैँ उनीहरूको मत अग्रणी हुन्छ। एक्लै निर्णय लिने जल्दबाजी र अहम् उनीहरूको कमजोर पक्ष हुन सक्छ। मित्र र सहकर्मीसँग साझेदारी गर्दा फाइदा बढी हुन्छ।','Dhanishta is the twenty third nakshatra and it covers the last part of Capricorn with the first six degrees forty minutes of Aquarius. Mars rules this star and the eight Vasus are its deities. A drum or a flute as a symbol shows music, group life and wealth. People born here are energetic, decisive and capable of leading a group. The Mars influence gives them courage and a strong competitive spirit. A natural love of music and art often earns them a name in public life, and in group matters their opinion usually leads. Haste in deciding alone and ego can become their weak side, while partnership with friends and colleagues tends to bring better results.',
'१. ऊर्जावान् र निर्णायक नेतृत्व
२. संगीत र कलाप्रति प्राकृतिक प्रतिभा
३. समूहमा आर्थिक विषयमा प्रभाव
४. साहस र प्रतिस्पर्धाको भावना
५. अहम् र छिटो निर्णयमा सावधानी',
'१. करियर: संगीत, कला, व्यापार र समूह नेतृत्वमा सफलता
२. सम्बन्ध: साथीसँग भावनात्मक जोड, सहकर्मीसँग बहस
३. स्वास्थ्य: रक्त, मुटु र स्नायुसम्बन्धी समस्या
४. आर्थिक: समूह वा टोलीमा धन आर्जन, खर्च बढी
५. शिक्षा: तालिका, ज्योतिष र संगीतमा विशेष रुचि',
'Vedanga Jyotisha','धनिष्ठा','सबैभन्दा धनी (the most wealthy)'),
(76,'शतभिषा चौबीसौं नक्षत्र हो र यो कुम्भ राशिको ६ डिग्री ४० देखि २० डिग्री सम्म फैलिएको छ। यसको स्वामी ग्रह राहु र देवता वरुण हुन्। सय चिकित्सक भनिने यो नक्षत्र खाली वृत्तको प्रतीक बोकेको छ, जसले गोपनीयता र पूर्णतालाई जनाउँछ। यहाँ जन्मेका व्यक्ति अनुसन्धानात्मक, विश्लेषणात्मक र एकान्तप्रिय हुन्छन्। राहुको प्रभावले उनीहरूको मन गुप्त र रहस्यमय कुराप्रति लैजान्छ। उपचार, ज्योतिष र विज्ञान जस्ता क्षेत्रमा उनीहरूको बुद्धि उत्कृष्ट काम गर्छ। वरुणको प्रभावले जल र समुद्रसँग जोडिएका काममा पनि भाग्य हुन्छ। मानिसहरू उनीहरूको उपचार र सल्लाहमा विश्वास राख्छन्। सामाजिक रूपमा बासी वा छुट्टाछुट्टै रहने बानीले गर्दा अरूसँग दूरी बढ्न सक्छ।','Shatabhisha is the twenty fourth nakshatra and it spreads from six degrees forty minutes to twenty degrees of Aquarius. Rahu is the ruling planet and Varuna, lord of the cosmic waters, is its deity. This star, called the hundred physicians, carries the symbol of an empty circle which stands for secrecy and completeness. People born here are research minded, analytical and fond of solitude, and the Rahu influence pulls their mind toward hidden and mysterious subjects. Their intelligence works well in healing, astrology and science, though quiet outside they carry deep feeling within. The Varuna influence also brings luck in work linked with water and the sea, while people trust their cure and their advice. A habit of staying aloof can at times create distance from others.',
'१. अनुसन्धान र विश्लेषणमा उत्कृष्ट बुद्धि
२. एकान्तमा काम गर्न रुचाउने स्वभाव
३. उपचार र ज्योतिषमा प्राकृतिक क्षमता
४. गोपनीयता र विश्वास जित्ने गुण
५. सामाजिक दूरी बढाउने छरिलो बानी',
'१. करियर: चिकित्सा, ज्योतिष, अनुसन्धान र प्रविधिमा सफलता
२. सम्बन्ध: कम बोल्ने तर गहिरो विश्वासयोग्य, उदासीनता सावधानी
३. स्वास्थ्य: नसा, रक्त र जननाङ्गसम्बन्धी गोप्य समस्या
४. आर्थिक: गोप्य र अनियमित स्रोतबाट आय, चपलताले लाभ
५. शिक्षा: खगोल, ज्योतिष र गुह्य विज्ञानमा गहिरो अध्ययन',
'Vedanga Jyotisha','शतभिषा','शत वैद्य (the hundred healers)'),
(77,'पूर्व भाद्रपदा पच्चीसौं नक्षत्र हो जुन कुम्भको अन्तिम भाग र मीन राशिको ३ डिग्री २० सम्म फैलिएको छ। यसको स्वामी ग्रह बृहस्पति र देवता अज एकपाद हुन्, जो शिवको एक रूप हो। शवदाहको चारपाइको अगाडिका खुट्टा जस्तो प्रतीकले मृत्यु, रूपान्तरण र नयाँ जागरणलाई जनाउँछ। यहाँ जन्मेका व्यक्ति बुद्धिमान, विद्वान र रहस्यमय विषयमा गहिरो ज्ञान राख्छन्। आध्यात्मिक उन्नतिको खोजी उनीहरूको जीवनको केन्द्र हुन्छ। कठोर परिश्रम र दृढ लक्ष्यप्राप्तिको मनोवृत्ले नेतृत्व र व्यापारमा उनलाई सफल बनाउँछ। अर्को छेउमा छिटो रिसाउने र उग्र हुने प्रवृत्ति पनि देखिन्छ। बुद्धि, तपस्या र कर्मको संयोग नै यस नक्षत्रको द्वैतमय प्रकृतिको सार हो।','Purva Bhadrapada is the twenty fifth nakshatra and it covers the last part of Aquarius with the first three degrees twenty minutes of Pisces. Jupiter rules this star and Aja Ekapada, a form of Shiva, is its deity. The front legs of a funeral cot as a symbol speak of death, transformation and awakening. People born here are learned and carry deep knowledge of mysterious subjects. The search for spiritual growth stands at the centre of their life. Hard work and firm pursuit of goals make them succeed in leadership and business. On the other side a tendency to lose temper can appear, while a blend of wisdom, penance and action is the essence of this twofold nature.',
'१. गहिरो ज्ञान र अध्ययन क्षमता
२. आध्यात्मिक जागरणप्रति तीव्र चाहना
३. कठोर परिश्रम र दृढ लक्ष्य प्राप्ति
४. नेतृत्व तथा व्यापारमा कुशलता
५. छिटो रिस र उग्र प्रकृतिलाई सन्तुलन गर्ने जरुरी',
'१. करियर: शिक्षण, लेखन, वित्त र अनुसन्धानमा उत्कृष्टता
२. सम्बन्ध: भावना गोप्य राख्ने, रिसले दूरी ल्याउन सक्ने
३. स्वास्थ्य: पेट, कलेजो र हड्डीसम्बन्धी समस्या
४. आर्थिक: परिश्रमबाट सम्पत्धि, दीर्घकालीन लगानीमा लाभ
५. शिक्षा: दर्शन, विज्ञान र गुह्य विषयमा विशेष निपुणता',
'Vedanga Jyotisha','पूर्व भाद्रपदा','पहिलो भाग्यवान (the earlier fortunate one)'),
(78,'उत्तर भाद्रपदा छब्बीसौं नक्षत्र हो र यो मीन राशिको ३ डिग्री २० देखि १६ डिग्री ४० सम्म फैलिएको छ। यसको स्वामी ग्रह शनि र देवता अहिर्बुध्न्य हुन्। शय्याको पछिल्ला खुट्टा वा पानीमा सर्पको प्रतीकले गहिराइ, स्थिरता र आध्यात्मिकतालाई जनाउँछ। यहाँ जन्मेका व्यक्ति कुशल वक्ता, उदार हृदयका र निष्पक्ष स्वभावका हुन्छन्। शनिको प्रभावले उनीहरूमा संयम, धैर्य र ज्ञानको गहिराइ बढाउँछ। योग, ध्यान र दर्शनमा रुचि राख्ने उनीहरूको स्वाभाविक झुकाव हो। समाजमा निष्पक्ष र ईमानदार भएकाले सम्मान पाउँछन्। परिवारप्रति समर्पित र बच्चाहरूप्रति स्नेही हुन्छन्। कहिलेकाहीँ आलस्य र निर्णय लिन ढिलो हुने बानीले अवसर गुमाउन सक्छन्।','Uttara Bhadrapada is the twenty sixth nakshatra and it spreads from three degrees twenty minutes to sixteen degrees forty minutes of Pisces. Saturn rules this star and Ahirbudhnyana, the serpent of the deep, is its deity. The back legs of a bed or a serpent in water as a symbol show depth, stability and spirituality. People born here are skilled speakers, generous in heart and neutral in outlook. The Saturn influence adds restraint, patience and depth of knowledge, and an interest in yoga, meditation and philosophy comes naturally. Being fair and honest earns them respect in society. They stay devoted to family and affectionate toward children, though laziness and delay in decision can make them lose opportunities.',
'१. कुशल वाक्पटुता र विचारको गहिराइ
२. निष्पक्ष र ईमानदार स्वभाव
३. योग, ध्यान र दर्शनप्रति रुचि
४. परिवारप्रति समर्पण र संयम
५. आलस्य र ढिलो निर्णयले अवसर गुमाउने समस्या',
'१. करियर: शिक्षण, परामर्श, धर्म र सामाजिक संस्थामा सफलता
२. सम्बन्ध: स्नेही र भरपर्दा, जीवनसाथीसँग दीर्घ सुख
३. स्वास्थ्य: मुटु, रक्तचाप र जरासम्बन्धी समस्या
४. आर्थिक: स्थिर आय र बचत, जीवनको उत्तरार्धमा सम्पन्नता
५. शिक्षा: धर्मग्रन्थ र दर्शन अध्ययनमा उत्कृष्टता',
'Vedanga Jyotisha','उत्तर भाद्रपदा','पछिल्लो भाग्यवान (the later fortunate one)'),
(79,'रेवती सत्ताउं र अन्तिम नक्षत्र हो जुन मीन राशिको १६ डिग्री ४० देखि ३० डिग्री सम्म फैलिएको छ। यसको स्वामी ग्रह बुध र देवता यात्रा र पोषणका देवता पूषा हुन्। माछाको जोडी चिन्हले पोषण, मार्गदर्शन र यात्राको समापनलाई जनाउँछ। यहाँ जन्मेका व्यक्ति दयालु, करुणामय र सहयोगी स्वभावका हुन्छन्। बुधको प्रभावले उनीहरूको बुद्धि चाँडो र सञ्चार कला सुन्दर बन्छ। नयाँ कुरा सिक्ने रचनात्मक मनले कला, संगीत र लेखनमा प्रतिभा दिन्छ। अरूलाई मार्गदर्शन दिने रुचि उनीहरूको स्वभावकै अंश हो। धार्मिक, शुद्ध र मिलनसार भएकाले समाजमा प्रिय बन्छन्। जीवनको यात्रा पूरा भएपछि पनि उनीहरूले अरूको हेरचाह गर्ने बानी जीवनभर कायम रहन्छ।','Revati is the twenty seventh and final nakshatra and it covers sixteen degrees forty minutes to thirty degrees of Pisces. Mercury rules this star and Pushan, deity of travel and nourishment, is its presiding power. A pair of fish as a symbol shows nourishment, guidance and the close of a journey. People born here are kind, compassionate and helpful by temperament. The Mercury influence makes their intellect quick and their way of speaking graceful. A creative mind that loves learning gives them talent in art, music and writing, and an interest in guiding others is part of their nature. Being religious, clean in habit and sociable, they are loved in society, and even after their own journey the habit of caring for others stays for life.',
'१. दयालु र करुणामय स्वभाव
२. रचनात्मक बुद्धि र सुन्दर सञ्चार कला
३. अरूलाई मार्गदर्शन गर्ने प्राकृतिक योग्यता
४. शुद्ध बानी र मिलनसार व्यवहार
५. यात्रा र परिवर्तनसँग गहिरो जोड',
'१. करियर: कला, मिडिया, शिक्षण र सेवामा ख्याति
२. सम्बन्ध: स्नेही र सहयोगी, अरूको हेरचाह गर्ने जीवनसाथी
३. स्वास्थ्य: पाचन, निद्रा र मानसिक तनावसम्बन्धी समस्या
४. आर्थिक: सम्मानजनक आय, यात्रा र सेवाबाट लाभ
५. शिक्षा: भाषा, सञ्चार र आध्यात्मिक अध्ययनमा उत्कृष्टता',
'Vedanga Jyotisha','रेवती','समृद्ध र पोषण दिने (the wealthy and the nourishing)');

INSERT INTO topic_remedies (id, topic_id, remedy_np, remedy_en, sort_order) VALUES
(34,53,'आइतबार गणेशजीलाई दुध र मोदक अर्पण गर्नुहोस् र सन्ध्यामा गणेश उपनिषदको पाठ गर्नुहोस्।','Offer milk and sweets to Lord Ganesha on Sunday and read the Upanishad in the evening.',1),
(35,53,'शनिबार सेतो कम्बल वा कालो तिलको दान गर्नुहोस् र कुनै पनि यात्रा सुरु गर्नुअघि गणेशजीको स्मरण गर्नुहोस्।','Donate a white blanket or black sesame on Saturday and remember Lord Ganesha before starting any journey.',2),
(36,54,'शुक्रबार सकुनमा सेतो फूल र चाउचाउ लक्ष्मी देवीलाई अर्पण गर्नुहोस्।','Offer white flowers and sweets to Goddess Lakshmi on Friday morning.',1),
(37,54,'शुक्रबार सेतो वस्त्र र चामलको दान गर्नुहोस् र शान्तिका लागि शुक्र ग्रहको स्तोत्र पढ्नुहोस्।','Donate white cloth and rice on Friday and recite a hymn for the peace of Venus.',2),
(38,55,'आइतबार बिहान उदयमा सूर्यलाई जल अर्पण गर्नुहोस् र गायत्री मन्त्रको जप गर्नुहोस्।','Offer water to the rising Sun on Sunday morning and chant the Gayatri Mantra.',1),
(39,55,'आइतबार गेहूँ वा रातो वस्त्रको दान गर्नुहोस् र अग्निदेवलाई आहुति दिनुहोस्।','Donate wheat or red cloth on Sunday and make an offering to the fire deity.',2),
(40,56,'सोमबार शिवलिङ्गमा जल चढाउनुहोस् र सेतो मिठाई परिवारमा वितरण गर्नुहोस्।','Pour water on a Shiva lingam on Monday and distribute white sweets in the family.',1),
(41,56,'सोमबार सेतो वस्त्र वा चामलको दान गर्नुहोस् र चन्द्र ग्रहको शान्तिका लागि शिवस्तोत्र पढ्नुहोस्।','Donate white cloth or rice on Monday and recite a Shiva hymn for the peace of the Moon.',2),
(42,57,'मंगलबार हनुमान मन्दिरमा रातो वस्त्र चढाउनुहोस् र हनुमान चालीसाको पाठ गर्नुहोस्।','Offer red cloth at a Hanuman temple on Tuesday and recite the Hanuman Chalisa.',1),
(43,57,'मंगलबार रातो मसुरो वा मसुर दालको दान गर्नुहोस् र गलत बोलीबाट बच्नुहोस्।','Donate red lentils on Tuesday and keep a check on harsh speech.',2),
(44,58,'शनिबार नरिवल र कालो तिलको दान गर्नुहोस् र दुर्गा सप्तशतीको एक अध्याय पढ्नुहोस्।','Donate coconut and black sesame on Saturday and read one chapter of the Durga Saptashati.',1),
(45,58,'बुधबार हनुमानजीलाई नरिवल चढाउनुहोस् र राहु ग्रहको शान्तिका लागि रुद्र गायत्रीको जप गर्नुहोस्।','Offer a coconut to Lord Hanuman on Wednesday and chant the Rudra Gayatri for the peace of Rahu.',2),
(46,59,'बिहीबार पीलो वस्त्र र केराको भोग विष्णु वा गुरु देवतालाई अर्पण गर्नुहोस्।','Offer yellow cloth and banana to Lord Vishnu or the guru deity on Thursday.',1),
(47,59,'बिहीबार बेसार वा पीलो चामलको दान गर्नुहोस् र वृद्ध विद्वानलाई भोजन खुवाउनुहोस्।','Donate turmeric or yellow rice on Thursday and feed an elderly scholar.',2),
(48,60,'शनिबार शनि देवतालाई तोरीको तेल चढाउनुहोस् र दीपक बाल्नुहोस्।','Pour mustard oil for Lord Saturn on Saturday and light a lamp in his honour.',1),
(49,60,'शनिबार कालो वस्त्र वा फलामको दान गर्नुहोस् र गरिब व्यक्तिलाई भोजन गराउनुहोस्।','Donate black cloth or iron on Saturday and provide a meal to a poor person.',2),
(50,61,'बुधबार हरियो मुगको दान गर्नुहोस् र गायलाई हरियो चारा खुवाउनुहोस्।','Donate green gram on Wednesday and feed green fodder to a cow.',1),
(51,61,'बुधबार विष्णु वा गणेशजीका अगाडि दियो बाल्नुहोस् र बुद्ध ग्रहको शान्तिका लागि बुधावतारको पाठ गर्नुहोस्।','Light a lamp before Lord Vishnu or Ganesha on Wednesday and read a hymn for the peace of Mercury.',2),
(52,62,'आइतबार गणेशजीलाई दुध अर्पण गर्नुहोस् र पितृहरूको स्मरण गरी तर्पण गर्नुहोस्।','Offer milk to Lord Ganesha on Sunday and remember the ancestors while making a water offering.',1),
(53,62,'आइतबार कालो तिल वा कम्बलको दान गर्नुहोस् र कुल देवताको पूजा गर्नुहोस्।','Donate black sesame or a blanket on Sunday and worship the family deity.',2),
(54,63,'शुक्रबार सेतो फूल र दही लक्ष्मी देवीलाई अर्पण गर्नुहोस् र मनपर्ने संगीत सुन्नुहोस्।','Offer white flowers and curd to Goddess Lakshmi on Friday and listen to music you love.',1),
(55,63,'शुक्रबार सेतो वस्त्रको दान गर्नुहोस् र जीवनसाथीसँग सम्बन्ध सुधार गर्न मन लगाउनुहोस्।','Donate white cloth on Friday and make a sincere effort to improve the bond with your partner.',2),
(56,64,'आइतबार बिहान सूर्यलाई जल अर्पण गर्नुहोस् र आर्यमा देवताको ध्यान गर्नुहोस्।','Offer water to the Sun on Sunday morning and meditate on the deity Aryaman.',1),
(57,64,'आइतबार गुरु वा वृद्धजनलाई फल र वस्त्र भेट गर्नुहोस्।','Present fruit and cloth to a teacher or an elderly person on Sunday.',2),
(58,65,'सोमबार शिवलिङ्गमा जल चढाउनुहोस् र सेतो चामलको दान गर्नुहोस्।','Pour water on a Shiva lingam on Monday and donate white rice.',1),
(59,65,'सोमबार हातले बनाएको वा हस्तकलाको काम शिव वा देवीको नाममा समर्पण गर्नुहोस्।','Dedicate any handmade or craft work in the name of Shiva or the goddess on Monday.',2),
(60,66,'मंगलबार हनुमानजीलाई रातो चोलो चढाउनुहोस् र रातो सिन्दूरको दान गर्नुहोस्।','Offer a red garment to Lord Hanuman on Tuesday and donate red vermilion.',1),
(61,66,'मंगलबार इटा वा रातो ईंटको दान गर्नुहोस् र आफ्नो कलाको काम अरूलाई सिकाउनुहोस्।','Donate bricks on Tuesday and teach your craft to someone else.',2),
(62,67,'शनिबार नरिवलको दान गर्नुहोस् र पीपल रूखमा जल चढाउनुहोस्।','Donate coconut on Saturday and pour water at a peepal tree.',1),
(63,67,'शनिबार कालो तिलको दान गर्नुहोस् र राहु शान्तिका लागि दुर्गाबाईको नाम जप्नुहोस्।','Donate black sesame on Saturday and chant in honour of Goddess Durga for the peace of Rahu.',2),
(64,68,'बिहीबार केरा र पीलो वस्त्र विष्णुलाई अर्पण गर्नुहोस्।','Offer banana and yellow cloth to Lord Vishnu on Thursday.',1),
(65,68,'बिहीबार विद्यार्थी वा गरिब बालबालिकालाई पुस्तक र भोजन गराउनुहोस्।','Provide books and a meal to a student or a poor child on Thursday.',2),
(66,69,'शनिबार शनि देवतालाई तोरीको तेल चढाउनुहोस् र मित्रहरूसँग शान्ति राख्न संकल्प गर्नुहोस्।','Pour mustard oil for Lord Saturn on Saturday and resolve to keep peace with friends.',1),
(67,69,'शनिबार कालो चामल वा फलामको दान गर्नुहोस् र मित्रतालाई सम्मान गर्ने वचन लिनुहोस्।','Donate black rice or iron on Saturday and take a vow to honour friendship.',2),
(68,70,'बुधबार गायलाई हरियो चारा खुवाउनुहोस् र विष्णु सहस्रनामको पाठ गर्नुहोस्।','Feed green fodder to a cow on Wednesday and read the Vishnu Sahasranama.',1),
(69,70,'बुधबार हरियो दालको दान गर्नुहोस् र आफ्ना गुरु तथा ज्येष्ठजनलाई सम्मान गर्नुहोस्।','Donate green lentils on Wednesday and show respect to your teachers and elders.',2),
(70,71,'आइतबार गणेशजीलाई दुध र कम्बलको दान गर्नुहोस् र मूल नक्षत्रको स्मरण गर्नुहोस्।','Offer milk to Lord Ganesha on Sunday, donate a blanket and remember the star Moola.',1),
(71,71,'बुधबार गणेशजीलाई दुध चढाउनुहोस् र अनावश्यक कुरा छोड्ने संकल्प गर्नुहोस्।','Pour milk for Lord Ganesha on Wednesday and resolve to give up what is unnecessary.',2),
(72,72,'शुक्रबार पवित्र जलमा सेतो फूल हाली देवीलाई अर्पण गर्नुहोस्।','Place a white flower in pure water and offer it to the goddess on Friday.',1),
(73,72,'शुक्रबार सेतो वस्त्र र चामलको दान गर्नुहोस् र जलसँग सम्बन्धित सेवा गर्नुहोस्।','Donate white cloth and rice on Friday and perform service linked with water.',2),
(74,73,'आइतबार बिहान सूर्यलाई जल अर्पण गर्नुहोस् र सूर्य ग्रहको शान्तिका लागि आदित्य हृदय स्तोत्र पढ्नुहोस्।','Offer water to the rising Sun on Sunday and read the Aditya Hridaya Stotra for peace.',1),
(75,73,'आइतबार गुरुजन र ज्येष्ठजनलाई भोजन गराई आशीर्वाद लिनुहोस्।','Feed teachers and elders on Sunday and seek their blessing.',2),
(76,74,'सोमबार शिवलिङ्गमा जल चढाउनुहोस् र सेतो चामलको दान गर्नुहोस्।','Pour water on a Shiva lingam on Monday and donate white rice.',1),
(77,74,'सोमबार गुरु वा शिक्षकलाई फल र वस्त्र भेट गर्नुहोस्।','Present fruit and cloth to a teacher on Monday.',2),
(78,75,'मंगलबार हनुमान मन्दिरमा दियो बाल्नुहोस् र हनुमान चालीसाको पाठ गर्नुहोस्।','Light a lamp at a Hanuman temple on Tuesday and recite the Hanuman Chalisa.',1),
(79,75,'मंगलबार रातो वस्त्र वा रातो दालको दान गर्नुहोस् र समूहको काममा सहयोग गर्नुहोस्।','Donate red cloth or red lentils on Tuesday and help in group work.',2),
(80,76,'शनिबार नरिवल र कालो वस्त्रको दान गर्नुहोस्।','Donate coconut and black cloth on Saturday.',1),
(81,76,'शनिबार शनि देवतालाई तोरीको तेल चढाउनुहोस् र राहु मन्त्रको जप गर्नुहोस्।','Pour mustard oil for Lord Saturn on Saturday and chant a mantra for Rahu.',2),
(82,77,'बिहीबार पीलो वस्त्र र बेसारको दान गर्नुहोस् र गुरुलाई प्रणाम गर्नुहोस्।','Donate yellow cloth and turmeric on Thursday and pay respect to the guru.',1),
(83,77,'बिहीबार विष्णुलाई पीलो भोग चढाउनुहोस् र ज्ञानको कुनै किताब पढ्न बस्नुहोस्।','Offer a yellow meal to Lord Vishnu on Thursday and sit down to read a book of knowledge.',2),
(84,78,'शनिबार शनि देवतालाई तोरीको तेल चढाउनुहोस् र फलामको दान गर्नुहोस्।','Pour mustard oil for Lord Saturn on Saturday and donate iron.',1),
(85,78,'शनिबार गरिब व्यक्तिलाई भोजन गराई कपडा दान गर्नुहोस्।','Provide a meal to a poor person and donate clothes on Saturday.',2),
(86,79,'बुधबार हरियो मुगको दान गर्नुहोस् र गायलाई हरियो चारा खुवाउनुहोस्।','Donate green gram on Wednesday and feed green fodder to a cow.',1),
(87,79,'बुधबार विष्णुलाई सेतो दुध चढाउनुहोस् र यात्रु वा गरिबलाई भोजन गराउनुहोस्।','Pour white milk for Lord Vishnu on Wednesday and feed a traveller or a poor person.',2);
;
;
